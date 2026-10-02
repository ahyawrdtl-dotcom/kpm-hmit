<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Uang Kas Realtime — KPM HMIT</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --glass-bg: rgba(15, 23, 42, 0.65);
      --glass-border: rgba(255, 255, 255, 0.1);
      --glass-shadow: 0 20px 50px 0 rgba(0, 0, 0, 0.6);
      --primary: #c084fc;
      --secondary: #818cf8;
      --accent: #38bdf8;
      --success: #4ade80;
      --danger: #f87171;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at 80% 20%, #1e1b4b, #0f172a 40%, #020617 80%);
      color: #f8fafc;
      min-height: 100vh;
      overflow-x: hidden;
      padding-bottom: 60px;
    }

    /* BACKGROUND MESH */
    .bg-mesh {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
      background:
        radial-gradient(circle at 10% 20%, rgba(129, 140, 248, 0.15), transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(192, 132, 252, 0.15), transparent 40%);
      filter: blur(50px);
    }

    /* NAVBAR */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 5%;
      background: rgba(2, 6, 23, 0.7);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--glass-border);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 15px;
      text-decoration: none;
      color: white;
    }

    .brand-logo {
      font-weight: 800;
      font-size: 22px;
      letter-spacing: 2px;
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav-links {
      display: flex;
      gap: 15px;
    }

    .btn-nav {
      padding: 10px 22px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-back {
      background: rgba(255, 255, 255, 0.08);
      color: white;
      border: 1px solid var(--glass-border);
    }

    .btn-back:hover {
      background: rgba(255, 255, 255, 0.18);
      transform: translateY(-2px);
    }

    .btn-refresh {
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      color: white;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(129, 140, 248, 0.3);
    }

    .btn-refresh:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(192, 132, 252, 0.5);
    }

    /* CONTAINER */
    .container {
      max-width: 1300px;
      margin: 40px auto;
      padding: 0 20px;
    }

    /* HEADER TITLE */
    .header-section {
      text-align: center;
      margin-bottom: 40px;
    }

    .badge-status {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 12px;
      background: rgba(56, 189, 248, 0.15);
      border: 1px solid rgba(56, 189, 248, 0.3);
      color: var(--accent);
    }

    .header-section h1 {
      font-size: 38px;
      font-weight: 800;
      background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 10px;
    }

    .header-section p {
      color: #94a3b8;
      font-size: 15px;
      max-width: 600px;
      margin: 0 auto;
    }

    /* STATS GRID */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }

    .stat-card {
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      border: 1px solid var(--glass-border);
      border-radius: 24px;
      padding: 24px;
      box-shadow: var(--glass-shadow);
      display: flex;
      align-items: center;
      gap: 20px;
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      border-color: rgba(255, 255, 255, 0.2);
    }

    .stat-icon {
      width: 56px;
      height: 56px;
      border-radius: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
    }

    .stat-icon.purple { background: rgba(192, 132, 252, 0.2); color: var(--primary); }
    .stat-icon.blue { background: rgba(129, 140, 248, 0.2); color: var(--secondary); }
    .stat-icon.green { background: rgba(74, 222, 128, 0.2); color: var(--success); }
    .stat-icon.red { background: rgba(248, 113, 113, 0.2); color: var(--danger); }

    .stat-info h3 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 2px;
    }

    .stat-info p {
      font-size: 13px;
      color: #94a3b8;
    }

    /* SEARCH & FILTER CONTROLS */
    .controls-card {
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      border: 1px solid var(--glass-border);
      border-radius: 24px;
      padding: 20px;
      margin-bottom: 30px;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: space-between;
      align-items: center;
    }

    .search-box {
      position: relative;
      flex: 1;
      min-width: 280px;
    }

    .search-box i {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
    }

    .search-input {
      width: 100%;
      padding: 14px 18px 14px 48px;
      border-radius: 30px;
      background: rgba(2, 6, 23, 0.6);
      border: 1px solid var(--glass-border);
      color: white;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      outline: none;
      transition: all 0.3s ease;
    }

    .search-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 15px rgba(192, 132, 252, 0.3);
    }

    .filter-tabs {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .tab-btn {
      padding: 8px 18px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--glass-border);
      color: #cbd5e1;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .tab-btn.active, .tab-btn:hover {
      background: var(--primary);
      color: #020617;
      font-weight: 700;
      border-color: var(--primary);
    }

    /* TABLE SECTION */
    .table-card {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: 28px;
      padding: 25px;
      box-shadow: var(--glass-shadow);
      overflow: hidden;
    }

    .group-title {
      font-size: 18px;
      font-weight: 700;
      letter-spacing: 1px;
      color: var(--primary);
      margin: 25px 0 15px 0;
      padding-left: 10px;
      border-left: 4px solid var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .group-title:first-of-type {
      margin-top: 5px;
    }

    .table-wrapper {
      overflow-x: auto;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.05);
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 14px;
    }

    th, td {
      padding: 14px 18px;
      white-space: nowrap;
    }

    th {
      background: rgba(15, 23, 42, 0.9);
      color: #94a3b8;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-bottom: 1px solid var(--glass-border);
      position: sticky;
      top: 0;
    }

    tr {
      border-bottom: 1px solid rgba(255, 255, 255, 0.03);
      transition: background 0.2s ease;
    }

    tr:hover {
      background: rgba(255, 255, 255, 0.04);
    }

    .member-name {
      font-weight: 600;
      color: #f1f5f9;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .badge-month {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .badge-month.paid {
      background: rgba(74, 222, 128, 0.15);
      border: 1px solid rgba(74, 222, 128, 0.4);
      color: var(--success);
    }

    .badge-month.unpaid {
      background: rgba(248, 113, 113, 0.15);
      border: 1px solid rgba(248, 113, 113, 0.4);
      color: var(--danger);
    }

    .status-summary {
      display: flex;
      gap: 6px;
    }

    .notice-box {
      background: rgba(129, 140, 248, 0.1);
      border: 1px solid rgba(129, 140, 248, 0.3);
      border-radius: 16px;
      padding: 16px 20px;
      margin-top: 30px;
      display: flex;
      align-items: center;
      gap: 15px;
      color: #cbd5e1;
      font-size: 13px;
    }

    .notice-box i {
      font-size: 20px;
      color: var(--secondary);
    }

    /* MODAL SEARCH EMPTY */
    .empty-state {
      text-align: center;
      padding: 40px;
      color: #94a3b8;
    }

    .empty-state i {
      font-size: 40px;
      margin-bottom: 10px;
      opacity: 0.5;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .header-section h1 { font-size: 28px; }
      .navbar { padding: 15px; }
      .controls-card { flex-direction: column; align-items: stretch; }
      .filter-tabs { overflow-x: auto; padding-bottom: 5px; }
    }
  </style>
</head>

<body>

  <div class="bg-mesh"></div>

  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="{{ url('/') }}" class="brand">
      <div class="brand-logo">KPM HMIT</div>
    </a>
    <div class="nav-links">
      <a href="{{ route('bendahara') }}" class="btn-nav btn-back">
        <i class="fa-solid fa-arrow-left"></i> Bendahara
      </a>
      <button onclick="refreshData()" class="btn-nav btn-refresh" id="refreshBtn">
        <i class="fa-solid fa-rotate-right" id="refreshIcon"></i> Refresh Realtime
      </button>
    </div>
  </nav>

  <!-- CONTENT CONTAINER -->
  <div class="container">

    <!-- HEADER TITLE -->
    <div class="header-section">
      <span class="badge-status"><i class="fa-solid fa-bolt"></i> Real-Time Synchronized</span>
      <h1>Monitoring Uang Kas 2026</h1>
      <p>Cek status kelunasan uang kas secara otomatis tanpa perlu konfirmasi manual ulang ke bendahara.</p>
    </div>

    @if($error)
      <div style="background: rgba(248, 113, 113, 0.15); border: 1px solid rgba(248, 113, 113, 0.3); color: #fca5a5; padding: 14px 20px; border-radius: 16px; margin-bottom: 25px; font-size: 14px;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}
      </div>
    @endif

    <!-- STATS CARDS -->
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
      <div class="stat-card">
        <div class="stat-icon purple">
          <i class="fa-solid fa-wallet"></i>
        </div>
        <div class="stat-info">
          <h3>Rp {{ number_format($summary['total_collected'] ?? 0, 0, ',', '.') }}</h3>
          <p>Total Uang Kas Terkumpul</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon blue">
          <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
          <h3>{{ $summary['total_members'] ?? 0 }} Anggota</h3>
          <p>Total Anggota Terdaftar</p>
        </div>
      </div>
    </div>

    <!-- CONTROLS CARD -->
    <div class="controls-card">
      <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Cari nama anggota (contoh: Rava, David, Naira)..." onkeyup="filterData()">
      </div>

      <div class="filter-tabs">
        <button class="tab-btn active" onclick="filterGroup('ALL', this)">Semua Komisi</button>
        @foreach(array_keys($groups) as $gName)
          <button class="tab-btn" onclick="filterGroup('{{ $gName }}', this)">{{ $gName }}</button>
        @endforeach
      </div>
    </div>

    <!-- TABLE CARD -->
    <div class="table-card">

      <div id="tableContainer">
        @foreach($groups as $groupName => $members)
          <div class="group-block" data-group="{{ $groupName }}">
            <div class="group-title">
              <i class="fa-solid fa-layer-group"></i> {{ $groupName }}
            </div>

            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Anggota</th>
                    @foreach($months as $month)
                      <th style="text-align: center;">{{ $month }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach($members as $index => $member)
                    <tr class="member-row" data-name="{{ strtolower($member['name']) }}" data-group="{{ $groupName }}">
                      <td>{{ $index + 1 }}</td>
                      <td class="member-name">
                        <i class="fa-regular fa-user" style="color: var(--secondary);"></i>
                        <span>{{ $member['name'] }}</span>
                      </td>
                      @foreach($months as $mName)
                        @php
                          $payment = $member['payments'][$mName] ?? ['is_paid' => false];
                        @endphp
                        <td style="text-align: center;">
                          @if($payment['is_paid'])
                            <span class="badge-month paid" title="Lunas Rp20.000">
                              <i class="fa-solid fa-check" style="margin-right: 4px;"></i> Rp20k
                            </span>
                          @else
                            <span class="badge-month unpaid" title="Belum Bayar">
                              Rp0
                            </span>
                          @endif
                        </td>
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endforeach
      </div>

      <div id="emptyState" class="empty-state" style="display: none;">
        <i class="fa-solid fa-user-slash"></i>
        <p>Tidak ada nama anggota yang cocok dengan pencarian kamu.</p>
      </div>

    </div>

    <!-- NOTICE BOX -->
    <div class="notice-box">
      <i class="fa-solid fa-circle-info"></i>
      <div>
        <strong>Informasi Bendahara:</strong> Data di atas diperbarui secara langsung dari Google Spreadsheet resmi KPM HMIT. Jika kamu baru saja membayar via Google Form / Transfer, mohon tunggu sebentar hingga bendahara memverifikasi di sheet master.
      </div>
    </div>

  </div>

  <script>
    let activeGroup = 'ALL';

    function filterGroup(groupName, element) {
      activeGroup = groupName;
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      element.classList.add('active');
      filterData();
    }

    function filterData() {
      const query = document.getElementById('searchInput').value.toLowerCase().trim();
      const groupBlocks = document.querySelectorAll('.group-block');
      let totalVisible = 0;

      groupBlocks.forEach(block => {
        const blockGroup = block.getAttribute('data-group');
        const rows = block.querySelectorAll('.member-row');
        let visibleInBlock = 0;

        rows.forEach(row => {
          const name = row.getAttribute('data-name');
          const matchesGroup = (activeGroup === 'ALL' || blockGroup === activeGroup);
          const matchesSearch = (!query || name.includes(query));

          if (matchesGroup && matchesSearch) {
            row.style.display = '';
            visibleInBlock++;
            totalVisible++;
          } else {
            row.style.display = 'none';
          }
        });

        if (visibleInBlock > 0) {
          block.style.display = '';
        } else {
          block.style.display = 'none';
        }
      });

      const emptyState = document.getElementById('emptyState');
      if (totalVisible === 0) {
        emptyState.style.display = 'block';
      } else {
        emptyState.style.display = 'none';
      }
    }

    function refreshData() {
      const icon = document.getElementById('refreshIcon');
      icon.classList.add('fa-spin');

      fetch("{{ route('kas.refresh') }}")
        .then(res => res.json())
        .then(data => {
          setTimeout(() => {
            icon.classList.remove('fa-spin');
            window.location.reload();
          }, 600);
        })
        .catch(err => {
          icon.classList.remove('fa-spin');
          window.location.reload();
        });
    }
  </script>
</body>

</html>
