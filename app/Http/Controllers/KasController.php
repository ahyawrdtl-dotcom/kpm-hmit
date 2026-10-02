<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class KasController extends Controller
{
    /**
     * Display the Real-Time Kas Monitoring Page
     */
    public function index(Request $request)
    {
        $sheetUrl = env('GOOGLE_SHEET_KAS_URL');
        $months = ['APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
        
        $data = null;
        $error = null;

        if ($sheetUrl) {
            $data = Cache::remember('kas_data_sheet', 60, function () use ($sheetUrl) {
                return $this->fetchAndParseSheet($sheetUrl);
            });
        }

        // If no sheet URL configured or fetch returned empty, use fallback data
        if (!$data || empty($data['groups'])) {
            $data = $this->getFallbackData();
            if ($sheetUrl) {
                $error = "Gagal mengambil data dari Google Sheet. Menggunakan data lokal.";
            }
        }

        return view('kas', [
            'months' => $months,
            'groups' => $data['groups'] ?? [],
            'summary' => $data['summary'] ?? [],
            'error' => $error,
            'hasCustomSheet' => !empty($sheetUrl)
        ]);
    }

    /**
     * API Endpoint to force refresh cache and return JSON
     */
    public function refresh()
    {
        Cache::forget('kas_data_sheet');
        $sheetUrl = env('GOOGLE_SHEET_KAS_URL');
        
        if ($sheetUrl) {
            $data = $this->fetchAndParseSheet($sheetUrl);
            if ($data && !empty($data['groups'])) {
                Cache::put('kas_data_sheet', $data, 60);
                return response()->json(['success' => true, 'data' => $data]);
            }
        }

        return response()->json(['success' => true, 'data' => $this->getFallbackData(), 'is_fallback' => true]);
    }

    /**
     * Fetch CSV from Google Sheets URL and parse rows into grouped categories & months
     */
    private function fetchAndParseSheet($url)
    {
        try {
            $csvUrl = $this->convertToCsvUrl($url);
            
            $csvContent = null;
            try {
                $response = Http::withoutVerifying()->timeout(10)->get($csvUrl);
                if ($response->successful()) {
                    $csvContent = $response->body();
                }
            } catch (\Exception $e) {
                // Fallback to file_get_contents with stream context
                $context = stream_context_create([
                    "ssl" => [
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ]
                ]);
                $csvContent = @file_get_contents($csvUrl, false, $context);
            }

            if (!$csvContent) {
                return null;
            }

            $lines = explode("\n", str_replace("\r", "", $csvContent));
            
            $rows = [];
            foreach ($lines as $line) {
                if (trim($line) === '') continue;
                $rows[] = str_getcsv($line);
            }

            return $this->parseCsvRows($rows);

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Convert Google Sheet URL to direct CSV export link
     */
    private function convertToCsvUrl($url)
    {
        if (str_contains($url, 'gviz/tq') || str_contains($url, 'export?format=csv')) {
            if (!str_contains($url, 'sheet=')) {
                $url .= (str_contains($url, '?') ? '&' : '?') . 'sheet=Kas';
            }
            return $url;
        }

        if (preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $url, $matches)) {
            $spreadsheetId = $matches[1];
            return "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/gviz/tq?tqx=out:csv&sheet=Kas";
        }

        return $url;
    }

    /**
     * Parse raw CSV rows into categories, members, and payment status
     */
    private function parseCsvRows($rows)
    {
        $months = ['APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
        $defaultGroupSequence = ['INTI', 'ASPIRASI & EKSTERNAL', 'PENGAWASAN', 'KOMINFO', 'KRO'];
        $groupSeqIndex = 0;
        $currentGroup = $defaultGroupSequence[0];
        
        $groups = [];
        $totalCollected = 0;
        $totalUnpaidCount = 0;
        $totalPaidCount = 0;
        $memberCount = 0;

        foreach ($rows as $rowIndex => $row) {
            $cleanRow = array_map('trim', $row);
            $firstCol = $cleanRow[0] ?? '';
            $secondCol = $cleanRow[1] ?? '';

            // Skip total row or empty rows
            if (empty($firstCol) && empty($secondCol)) continue;
            if (in_array(strtoupper($firstCol), ['NO', 'UANG KAS KPM 2026', 'CASHFLOW BULANAN KPM 2026'])) continue;

            // Check if explicitly a Group Header row
            if (empty($secondCol) && !empty($firstCol) && !is_numeric($firstCol)) {
                $candidateGroup = $this->cleanGroupName($firstCol);
                if (!in_array($candidateGroup, ['NAMA', 'BULAN', 'NO'])) {
                    $currentGroup = $candidateGroup;
                    if (!isset($groups[$currentGroup])) {
                        $groups[$currentGroup] = [];
                    }
                    continue;
                }
            }

            // Check if first column is number "1" -> signifies start of a section
            if ($firstCol === '1' && $rowIndex > 1) {
                if (isset($defaultGroupSequence[$groupSeqIndex + 1])) {
                    $groupSeqIndex++;
                    $currentGroup = $defaultGroupSequence[$groupSeqIndex];
                }
            }

            // Valid member row: Col 0 is number, Col 1 is Member Name
            $name = $secondCol;
            if (!$name || is_numeric($name) || in_array(strtoupper($name), ['NAMA', 'BULAN'])) continue;

            $memberCount++;
            $payments = [];

            // Months are in columns index 2 to 10
            foreach ($months as $idx => $monthName) {
                $colIndex = 2 + $idx;
                $colVal = $cleanRow[$colIndex] ?? 'Rp0';
                $isPaid = $this->checkIsPaid($colVal);

                $payments[$monthName] = [
                    'amount' => $isPaid ? 20000 : 0,
                    'is_paid' => $isPaid,
                    'raw' => $colVal ?: 'Rp0'
                ];

                if ($isPaid) {
                    $totalCollected += 20000;
                    $totalPaidCount++;
                } else {
                    $totalUnpaidCount++;
                }
            }

            if (!isset($groups[$currentGroup])) {
                $groups[$currentGroup] = [];
            }

            $groups[$currentGroup][] = [
                'name' => $name,
                'group' => $currentGroup,
                'payments' => $payments,
                'unpaid_months' => array_keys(array_filter($payments, fn($p) => !$p['is_paid'])),
                'paid_months' => array_keys(array_filter($payments, fn($p) => $p['is_paid']))
            ];
        }

        // Clean empty groups
        $groups = array_filter($groups, fn($g) => count($g) > 0);

        return [
            'groups' => $groups,
            'summary' => [
                'total_collected' => $totalCollected,
                'total_paid_slots' => $totalPaidCount,
                'total_unpaid_slots' => $totalUnpaidCount,
                'total_members' => $memberCount,
            ]
        ];
    }

    private function cleanGroupName($name)
    {
        $name = strtoupper(trim($name));
        $name = str_replace(['UANG KAS KPM 2026', 'CASHFLOW BULANAN KPM 2026', 'NAMA'], '', $name);
        $name = trim($name);

        if (str_contains($name, 'INTI')) return 'INTI';
        if (str_contains($name, 'ASPIRASI')) return 'ASPIRASI & EKSTERNAL';
        if (str_contains($name, 'PENGAWASAN')) return 'PENGAWASAN';
        if (str_contains($name, 'KOMINFO')) return 'KOMINFO';
        if (str_contains($name, 'KRO')) return 'KRO';

        return $name ?: 'INTI';
    }

    private function checkIsPaid($val)
    {
        if (!$val) return false;
        $clean = preg_replace('/[^0-9]/', '', $val);
        if ($clean === '' || $clean === '0') return false;
        return (int)$clean > 0;
    }

    /**
     * Structured fallback data
     */
    private function getFallbackData()
    {
        $months = ['APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
        
        $rawGroups = [
            'INTI' => [
                ['David Nathan Honggo Kusumo', [true, true, true, false, true, false, false, false, false]],
                ['Naira Cahaya Putri Darmawan Sinaga', [true, true, true, false, true, false, false, false, false]],
                ['Neizshia Ratu Rahmadhani Ockry', [true, true, true, false, true, false, false, false, false]],
                ['Taryssa Nazwa Azani', [true, true, true, false, true, false, false, false, false]],
                ['Wildan AlFatan', [true, true, true, false, true, false, false, false, false]],
                ['Wirdatul Ahya', [true, true, true, false, true, true, true, true, false]],
                ['Rava Amesta', [false, false, true, false, true, false, false, false, false]],
                ['Deandra Azzahra Fadani', [false, false, true, false, true, false, false, false, false]],
            ],
            'ASPIRASI & EKSTERNAL' => [
                ['Alya Aziza Puteri', [true, true, true, false, true, false, false, false, false]],
                ['Farash Ibra Muhammad', [true, true, true, false, true, false, false, false, false]],
                ['Muhammad Fajri Fatullah Nur', [true, true, true, false, true, false, false, false, false]],
                ['Rakan Ghazian Adiwijaya', [true, true, true, false, true, false, false, false, false]],
                ['Rayvan Alifarlo Mahesworo', [true, true, true, false, false, false, false, false, false]],
                ['Tubagus Lingga Amru Permana', [true, true, true, false, false, false, false, false, false]],
                ['Naida Zahra Khalisha', [false, false, true, false, true, false, false, false, false]],
                ['Gian Pratama Sari', [false, false, true, false, true, true, false, false, false]],
                ['Dafa Azka Wardana', [false, false, true, false, true, false, false, false, false]],
            ],
            'PENGAWASAN' => [
                ['Fauzi Ridho Anshori', [true, true, true, false, true, false, false, false, false]],
                ['Jenifer huang', [true, true, true, false, true, false, false, false, false]],
                ['Kayla Azhwa Athalla A.', [true, true, true, false, true, false, false, false, false]],
            ]
        ];

        $groups = [];
        $totalCollected = 0;
        $totalPaidSlots = 0;
        $totalUnpaidSlots = 0;
        $memberCount = 0;

        foreach ($rawGroups as $groupName => $members) {
            $groups[$groupName] = [];
            foreach ($members as $mem) {
                $name = $mem[0];
                $statusList = $mem[1];
                $payments = [];
                $memberCount++;

                foreach ($months as $idx => $mName) {
                    $isPaid = $statusList[$idx] ?? false;
                    $payments[$mName] = [
                        'amount' => $isPaid ? 20000 : 0,
                        'is_paid' => $isPaid,
                        'raw' => $isPaid ? 'Rp20,000' : 'Rp0'
                    ];

                    if ($isPaid) {
                        $totalCollected += 20000;
                        $totalPaidSlots++;
                    } else {
                        $totalUnpaidSlots++;
                    }
                }

                $groups[$groupName][] = [
                    'name' => $name,
                    'group' => $groupName,
                    'payments' => $payments,
                    'unpaid_months' => array_keys(array_filter($payments, fn($p) => !$p['is_paid'])),
                    'paid_months' => array_keys(array_filter($payments, fn($p) => $p['is_paid']))
                ];
            }
        }

        return [
            'groups' => $groups,
            'summary' => [
                'total_collected' => $totalCollected,
                'total_paid_slots' => $totalPaidSlots,
                'total_unpaid_slots' => $totalUnpaidSlots,
                'total_members' => $memberCount,
            ]
        ];
    }
}
