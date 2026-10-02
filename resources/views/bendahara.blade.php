<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bendahara — Sistem Transaksi KPM HMIT</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: #c084fc;
      --secondary: #818cf8;
      --accent: #38bdf8;
      --bg-dark: #020617;
      --glass-bg: rgba(15, 23, 42, 0.65);
      --glass-border: rgba(255, 255, 255, 0.12);
      --glass-shadow: 0 25px 60px 0 rgba(0, 0, 0, 0.6);
      --btn-gradient: linear-gradient(135deg, var(--secondary), var(--primary));
      --text-glow: rgba(192, 132, 252, 0.4);
    }

    /* THEME PRESETS */
    body.theme-emerald {
      --primary: #34d399;
      --secondary: #059669;
      --accent: #6ee7b7;
      --text-glow: rgba(52, 211, 153, 0.4);
    }

    body.theme-cyan {
      --primary: #38bdf8;
      --secondary: #0284c7;
      --accent: #7dd3fc;
      --text-glow: rgba(56, 189, 248, 0.4);
    }

    body.theme-crimson {
      --primary: #fb7185;
      --secondary: #e11d48;
      --accent: #fda4af;
      --text-glow: rgba(251, 113, 133, 0.4);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
      color: white;
      background: var(--bg-dark);
      height: 100vh;
      transition: background 0.5s ease;
    }

    /* BACKGROUND PANNING */
    .bg {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: url("{{ asset('assets/kabinet.jpg') }}") center/cover no-repeat;
      z-index: -3;
      transform: scale(1.05);
      animation: bgPan 40s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes bgPan {
      0% { transform: scale(1.05) translate(0, 0); }
      100% { transform: scale(1.15) translate(-15px, -15px); }
    }

    /* OVERLAY */
    .overlay {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(2, 6, 23, 0.96) 100%);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      z-index: -2;
    }

    /* DYNAMIC MESH GLOW */
    .mesh-glow {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
      background:
        radial-gradient(circle at 20% 30%, var(--text-glow), transparent 45%),
        radial-gradient(circle at 80% 70%, rgba(129, 140, 248, 0.2), transparent 45%);
      filter: blur(60px);
      transition: all 0.5s ease;
    }

    /* NAVBAR / TOP TOOLBAR */
    .top-toolbar {
      position: fixed;
      top: 25px;
      right: 30px;
      left: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 50;
    }

    .brand-pill {
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      border: 1px solid var(--glass-border);
      padding: 10px 24px;
      border-radius: 30px;
      font-weight: 700;
      font-size: 14px;
      letter-spacing: 2px;
      color: white;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    .brand-pill span {
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      transition: all 0.3s ease;
    }

    .tools-group {
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .tool-btn {
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      border: 1px solid var(--glass-border);
      color: white;
      padding: 10px 18px;
      border-radius: 30px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .tool-btn:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-3px);
      border-color: rgba(255, 255, 255, 0.3);
    }

    /* THEME SELECTOR DROPDOWN */
    .theme-picker {
      position: relative;
    }

    .theme-options {
      position: absolute;
      top: 50px;
      right: 0;
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: 20px;
      padding: 10px;
      display: none;
      flex-direction: column;
      gap: 6px;
      min-width: 170px;
      box-shadow: var(--glass-shadow);
      z-index: 100;
    }

    .theme-options.show {
      display: flex;
      animation: fadeIn 0.3s ease;
    }

    .theme-dot-btn {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 14px;
      border-radius: 12px;
      border: none;
      background: transparent;
      color: white;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      width: 100%;
      text-align: left;
      transition: background 0.2s;
    }

    .theme-dot-btn:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
    }

    .dot.purple { background: #c084fc; box-shadow: 0 0 10px #c084fc; }
    .dot.emerald { background: #34d399; box-shadow: 0 0 10px #34d399; }
    .dot.cyan { background: #38bdf8; box-shadow: 0 0 10px #38bdf8; }
    .dot.crimson { background: #fb7185; box-shadow: 0 0 10px #fb7185; }

    /* LOADING SCREEN */
    #loading {
      position: fixed;
      width: 100%;
      height: 100%;
      background: #020617;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 999;
      transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
    }

    .logo {
      font-size: 36px;
      font-weight: 800;
      letter-spacing: 6px;
      background: linear-gradient(to right, var(--secondary), var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: pulseLogo 2.5s infinite alternate ease-in-out;
      text-shadow: 0 0 30px var(--text-glow);
    }

    @keyframes pulseLogo {
      0% { filter: drop-shadow(0 0 15px var(--secondary)); }
      100% { filter: drop-shadow(0 0 40px var(--primary)); }
    }

    /* PROGRESS BAR */
    .progress {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: rgba(255, 255, 255, 0.05);
      z-index: 10;
    }

    .progress-bar {
      height: 100%;
      width: 0%;
      background: linear-gradient(90deg, var(--secondary), var(--primary), var(--accent));
      background-size: 200% 200%;
      animation: gradientMove 3s ease infinite;
      transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 0 15px var(--primary);
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* MAIN CONTAINER */
    .container {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      perspective: 1200px;
      padding: 20px;
    }

    /* STEP CARDS */
    .step {
      display: none;
      max-width: 880px;
      width: 92%;
      opacity: 0;
      transform: translateY(60px) scale(0.92);
      transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);

      background: var(--glass-bg);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
      border-radius: 36px;
      padding: 55px;
      position: relative;
      overflow: hidden;
    }

    .step::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--secondary), var(--primary));
    }

    .step.active {
      display: block;
      opacity: 1;
      transform: translateY(0) scale(1);
    }

    .step-info {
      font-size: 12px;
      margin-bottom: 18px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--primary);
      font-weight: 700;
      background: rgba(255, 255, 255, 0.08);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px;
      border-radius: 20px;
      border: 1px solid var(--glass-border);
    }

    .step h2 {
      font-size: 40px;
      font-weight: 800;
      margin: 0 0 15px 0;
      color: #ffffff;
      text-shadow: 0 2px 15px rgba(0,0,0,0.5);
      letter-spacing: -0.5px;
    }

    .step p {
      font-size: 17px;
      color: #cbd5e1;
      line-height: 1.7;
      margin-bottom: 35px;
      font-weight: 300;
    }

    /* BUTTONS */
    .btn-container {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }

    button.btn-action {
      padding: 16px 36px;
      border: none;
      border-radius: 40px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      letter-spacing: 1px;
      font-size: 15px;
      transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    button.btn-back {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid var(--glass-border);
      color: #e2e8f0;
    }

    button.btn-back:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-4px);
    }

    button.btn-next {
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      color: white;
      box-shadow: 0 10px 25px var(--text-glow);
    }

    button.btn-next:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 35px var(--text-glow);
      filter: brightness(1.1);
    }

    button.btn-kas {
      background: rgba(56, 189, 248, 0.15);
      border: 1px solid rgba(56, 189, 248, 0.4);
      color: #7dd3fc;
    }

    button.btn-kas:hover {
      background: rgba(56, 189, 248, 0.3);
      transform: translateY(-4px);
    }

    /* CONTENT LAYOUT FOR STEPS 1-5 */
    .content {
      display: flex;
      align-items: center;
      gap: 50px;
      justify-content: center;
    }

    .step-img {
      width: 220px;
      padding: 20px;
      border-radius: 32px;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      animation: float 5s ease-in-out infinite;
      filter: drop-shadow(0 20px 35px rgba(0, 0, 0, 0.5));
      transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .step-img:hover {
      transform: scale(1.08) translateY(-10px) rotate(2deg);
      border-color: rgba(255, 255, 255, 0.3);
    }

    .text {
      text-align: left;
      max-width: 460px;
    }

    .typing {
      display: inline-block;
      overflow: hidden;
      border-right: 4px solid var(--primary);
      white-space: nowrap;
      animation: typing 3s steps(30, end), blink-caret 0.7s infinite;
      margin: 0 auto 15px auto;
      text-align: center;
      padding-right: 8px;
    }

    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }

    @keyframes blink-caret {
      50% { border-color: transparent }
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
      100% { transform: translateY(0); }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .content {
        flex-direction: column;
        text-align: center;
        gap: 30px;
      }
      .text { text-align: center; }
      .step-img { width: 160px; }
      .step { padding: 35px 20px; }
      .top-toolbar { top: 15px; left: 15px; right: 15px; }
      .brand-pill span { display: none; }
    }
  </style>
</head>

<body>

  <!-- LOADING -->
  <div id="loading">
    <div class="logo">KATHARSIS BENDAHARA</div>
  </div>

  <div class="bg"></div>
  <div class="overlay"></div>
  <div class="mesh-glow" id="meshGlow"></div>

  <!-- PROGRESS BAR -->
  <div class="progress">
    <div class="progress-bar" id="progressBar"></div>
  </div>

  <!-- TOP TOOLBAR -->
  <div class="top-toolbar">
    <a href="{{ url('/') }}" style="text-decoration: none;">
      <div class="brand-pill">
        <i class="fa-solid fa-compass"></i>
        <span id="txtPortal">PORTAL KPM</span>
      </div>
    </a>

    <div class="tools-group">
      <!-- CEK UANG KAS SHORTCUT -->
      <a href="{{ route('kas') }}" style="text-decoration: none;">
        <button class="tool-btn">
          <i class="fa-solid fa-wallet"></i>
          <span id="txtKasMenu">Cek Uang Kas</span>
        </button>
      </a>

      <!-- LANGUAGE SWITCHER -->
      <button class="tool-btn" onclick="toggleLanguage()">
        <i class="fa-solid fa-globe"></i>
        <span id="langLabel">ID</span>
      </button>

      <!-- THEME PICKER -->
      <div class="theme-picker">
        <button class="tool-btn" onclick="toggleThemeOptions()">
          <i class="fa-solid fa-palette"></i>
          <span id="txtTheme">Warna</span>
        </button>
        <div class="theme-options" id="themeOptions">
          <button class="theme-dot-btn" onclick="setTheme('purple')">
            <div class="dot purple"></div> Katharsis Neon
          </button>
          <button class="theme-dot-btn" onclick="setTheme('emerald')">
            <div class="dot emerald"></div> Cyber Emerald
          </button>
          <button class="theme-dot-btn" onclick="setTheme('cyan')">
            <div class="dot cyan"></div> Oceanic Aurora
          </button>
          <button class="theme-dot-btn" onclick="setTheme('crimson')">
            <div class="dot crimson"></div> Sunset Crimson
          </button>
        </div>
      </div>

      <!-- MUSIC TOGGLE -->
      <button class="tool-btn" onclick="toggleMusic()" id="musicBtn">
        <i class="fa-solid fa-music"></i>
      </button>
    </div>
  </div>

  <!-- CONTAINER -->
  <div class="container">

    <!-- STEP 0 -->
    <div class="step active" style="text-align: center;">
      <div class="step-info">
        <i class="fa-solid fa-shield-halved"></i> <span id="txtStep0Badge">KABINET KATHARSIS 2026</span>
      </div>
      <div style="display: flex; justify-content: center; width: 100%;">
        <h2 class="typing" id="txtStep0Title">Sistem Transaksi</h2>
      </div>
      <p id="txtStep0Desc">Alur Pengajuan & Reimburse Keuangan KPM HMIT</p>
      
      <div class="btn-container">
        <button class="btn-action btn-next" onclick="startApp()" id="txtStartBtn">
          <i class="fa-solid fa-play"></i> Mulai Alur Transaksi
        </button>
        <a href="{{ route('kas') }}" style="text-decoration: none;">
          <button class="btn-action btn-kas" id="txtKasShortcut">
            <i class="fa-solid fa-chart-pie"></i> Monitoring Kas Realtime
          </button>
        </a>
      </div>
    </div>

    <!-- STEP 1 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/pengajuan.jpeg') }}" class="step-img" alt="Pengajuan">
        <div class="text">
          <div class="step-info"><i class="fa-solid fa-1"></i> <span id="txtStep1Badge">TAHAP 1 DARI 5</span></div>
          <h2 id="txtStep1Title">Pengajuan</h2>
          <p id="txtStep1Desc">Komisi mengajukan kebutuhan barang atau anggaran dana kegiatan sebelum pembelian dilakukan kepada Bendahara.</p>
          <div class="btn-container">
            <button class="btn-action btn-back" onclick="prevStep()"><i class="fa-solid fa-arrow-left"></i> <span id="btnBack1">Kembali</span></button>
            <button class="btn-action btn-next" onclick="nextStep()"><span id="btnNext1">Lanjut</span> <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 2 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/approval.jpeg') }}" class="step-img" alt="Approval">
        <div class="text">
          <div class="step-info"><i class="fa-solid fa-2"></i> <span id="txtStep2Badge">TAHAP 2 DARI 5</span></div>
          <h2 id="txtStep2Title">Approval</h2>
          <p id="txtStep2Desc">Bendahara melakukan verifikasi kelayakan anggaran, mengecek kesesuaian harga, lalu memberikan persetujuan (ACC) atau Reject.</p>
          <div class="btn-container">
            <button class="btn-action btn-back" onclick="prevStep()"><i class="fa-solid fa-arrow-left"></i> <span id="btnBack2">Kembali</span></button>
            <button class="btn-action btn-next" onclick="nextStep()"><span id="btnNext2">Lanjut</span> <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 3 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/pembelian.jpeg') }}" class="step-img" alt="Pembelian">
        <div class="text">
          <div class="step-info"><i class="fa-solid fa-3"></i> <span id="txtStep3Badge">TAHAP 3 DARI 5</span></div>
          <h2 id="txtStep3Title">Pembelian</h2>
          <p id="txtStep3Desc">Setelah di-ACC, Komisi membeli barang sesuai rincian pengajuan yang telah disetujui tanpa mengubah kuantitas secara sepihak.</p>
          <div class="btn-container">
            <button class="btn-action btn-back" onclick="prevStep()"><i class="fa-solid fa-arrow-left"></i> <span id="btnBack3">Kembali</span></button>
            <button class="btn-action btn-next" onclick="nextStep()"><span id="btnNext3">Lanjut</span> <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 4 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/nota.jpeg') }}" class="step-img" alt="Nota">
        <div class="text">
          <div class="step-info"><i class="fa-solid fa-4"></i> <span id="txtStep4Badge">TAHAP 4 DARI 5</span></div>
          <h2 id="txtStep4Title">Kelengkapan Nota</h2>
          <p id="txtStep4Desc"><b>Nota resmi wajib mencantumkan:</b> Nama KPM HMIT Universitas Telkom, tanggal transaksi yang valid, serta cap/tanda tangan vendor.</p>
          <div class="btn-container">
            <button class="btn-action btn-back" onclick="prevStep()"><i class="fa-solid fa-arrow-left"></i> <span id="btnBack4">Kembali</span></button>
            <button class="btn-action btn-next" onclick="nextStep()"><span id="btnNext4">Lanjut</span> <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 5 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/reimburse.jpeg') }}" class="step-img" alt="Reimburse">
        <div class="text">
          <div class="step-info"><i class="fa-solid fa-check-double"></i> <span id="txtStep5Badge">TAHAP AKHIR</span></div>
          <h2 id="txtStep5Title">Pencairan (Reimburse)</h2>
          <p id="txtStep5Desc">Dana akan diganti dan ditransfer oleh Bendahara setelah seluruh bukti nota fisik & digital tervalidasi dengan lengkap.</p>
          <div class="btn-container">
            <button class="btn-action btn-back" onclick="prevStep()"><i class="fa-solid fa-arrow-left"></i> <span id="btnBack5">Kembali</span></button>
            <button class="btn-action btn-next" onclick="resetStep()"><i class="fa-solid fa-rotate-left"></i> <span id="btnReset">Selesai & Ulangi</span></button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- AUDIO -->
  <audio id="bgMusic" loop>
    <source src="{{ asset('assets/music.mp3') }}" type="audio/mpeg">
  </audio>

  <script>
    let current = 0;
    let currentLang = 'ID';
    const steps = document.querySelectorAll(".step");
    const progress = document.getElementById("progressBar");
    const music = document.getElementById("bgMusic");

    const dict = {
      ID: {
        portal: "PORTAL KPM",
        kasMenu: "Cek Uang Kas",
        theme: "Warna",
        step0Badge: "KABINET KATHARSIS 2026",
        step0Title: "Sistem Transaksi",
        step0Desc: "Alur Pengajuan & Reimburse Keuangan KPM HMIT",
        startBtn: "Mulai Alur Transaksi",
        kasShortcut: "Monitoring Kas Realtime",

        step1Badge: "TAHAP 1 DARI 5",
        step1Title: "Pengajuan",
        step1Desc: "Komisi mengajukan kebutuhan barang atau anggaran dana kegiatan sebelum pembelian dilakukan kepada Bendahara.",

        step2Badge: "TAHAP 2 DARI 5",
        step2Title: "Approval",
        step2Desc: "Bendahara melakukan verifikasi kelayakan anggaran, mengecek kesesuaian harga, lalu memberikan persetujuan (ACC) atau Reject.",

        step3Badge: "TAHAP 3 DARI 5",
        step3Title: "Pembelian",
        step3Desc: "Setelah di-ACC, Komisi membeli barang sesuai rincian pengajuan yang telah disetujui tanpa mengubah kuantitas secara sepihak.",

        step4Badge: "TAHAP 4 DARI 5",
        step4Title: "Kelengkapan Nota",
        step4Desc: "Nota resmi wajib mencantumkan: Nama KPM HMIT Universitas Telkom, tanggal transaksi yang valid, serta cap/tanda tangan vendor.",

        step5Badge: "TAHAP AKHIR",
        step5Title: "Pencairan (Reimburse)",
        step5Desc: "Dana akan diganti dan ditransfer oleh Bendahara setelah seluruh bukti nota fisik & digital tervalidasi dengan lengkap.",

        btnBack: "Kembali",
        btnNext: "Lanjut",
        btnReset: "Selesai & Ulangi"
      },
      EN: {
        portal: "KPM PORTAL",
        kasMenu: "Check Dues",
        theme: "Theme",
        step0Badge: "KATHARSIS CABINET 2026",
        step0Title: "Transaction System",
        step0Desc: "Financial Submission & Reimbursement Workflow",
        startBtn: "Start Transaction Flow",
        kasShortcut: "Real-time Dues Monitoring",

        step1Badge: "STEP 1 OF 5",
        step1Title: "Submission",
        step1Desc: "Commissions submit item needs or activity budget proposals to the Treasurer prior to purchase.",

        step2Badge: "STEP 2 OF 5",
        step2Title: "Approval",
        step2Desc: "Treasurer verifies budget eligibility, checks price reasonableness, and grants Approval (ACC) or Rejection.",

        step3Badge: "STEP 3 OF 5",
        step3Title: "Purchasing",
        step3Desc: "Once approved, the Commission purchases goods strictly according to the approved submission details.",

        step4Badge: "STEP 4 OF 5",
        step4Title: "Receipt Verification",
        step4Desc: "Official receipt must include: KPM HMIT Telkom University name, valid transaction date, and vendor stamp/signature.",

        step5Badge: "FINAL STEP",
        step5Title: "Reimbursement",
        step5Desc: "Funds will be reimbursed and transferred by the Treasurer after all physical & digital receipt proof is validated.",

        btnBack: "Back",
        btnNext: "Next",
        btnReset: "Finish & Restart"
      }
    };

    /* INITIAL LOADING */
    setTimeout(() => {
      const loading = document.getElementById("loading");
      loading.style.opacity = "0";
      setTimeout(() => {
        loading.style.visibility = "hidden";
      }, 800);
    }, 1500);

    /* STEP NAVIGATION */
    function showStep(i) {
      steps.forEach(s => s.classList.remove("active"));
      steps[i].classList.add("active");
      progress.style.width = (i / (steps.length - 1)) * 100 + "%";
    }

    function nextStep() {
      if (current < steps.length - 1) {
        current++;
        showStep(current);
      }
    }

    function prevStep() {
      if (current > 0) {
        current--;
        showStep(current);
      }
    }

    function resetStep() {
      current = 0;
      showStep(current);
    }

    function startApp() {
      music.volume = 0.3;
      music.play().catch(() => {});
      nextStep();
    }

    function toggleMusic() {
      const musicBtn = document.getElementById("musicBtn");
      if (music.paused) {
        music.play();
        musicBtn.style.color = "var(--primary)";
      } else {
        music.pause();
        musicBtn.style.color = "white";
      }
    }

    /* THEME SWITCHER */
    function toggleThemeOptions() {
      document.getElementById("themeOptions").classList.toggle("show");
    }

    function setTheme(theme) {
      document.body.className = '';
      if (theme !== 'purple') {
        document.body.classList.add('theme-' + theme);
      }
      document.getElementById("themeOptions").classList.remove("show");
    }

    /* LANGUAGE SWITCHER */
    function toggleLanguage() {
      currentLang = currentLang === 'ID' ? 'EN' : 'ID';
      document.getElementById("langLabel").innerText = currentLang;

      const t = dict[currentLang];

      document.getElementById("txtPortal").innerText = t.portal;
      document.getElementById("txtKasMenu").innerText = t.kasMenu;
      document.getElementById("txtTheme").innerText = t.theme;

      document.getElementById("txtStep0Badge").innerText = t.step0Badge;
      document.getElementById("txtStep0Title").innerText = t.step0Title;
      document.getElementById("txtStep0Desc").innerText = t.step0Desc;
      document.getElementById("txtStartBtn").innerHTML = `<i class="fa-solid fa-play"></i> ${t.startBtn}`;
      document.getElementById("txtKasShortcut").innerHTML = `<i class="fa-solid fa-chart-pie"></i> ${t.kasShortcut}`;

      document.getElementById("txtStep1Badge").innerText = t.step1Badge;
      document.getElementById("txtStep1Title").innerText = t.step1Title;
      document.getElementById("txtStep1Desc").innerText = t.step1Desc;

      document.getElementById("txtStep2Badge").innerText = t.step2Badge;
      document.getElementById("txtStep2Title").innerText = t.step2Title;
      document.getElementById("txtStep2Desc").innerText = t.step2Desc;

      document.getElementById("txtStep3Badge").innerText = t.step3Badge;
      document.getElementById("txtStep3Title").innerText = t.step3Title;
      document.getElementById("txtStep3Desc").innerText = t.step3Desc;

      document.getElementById("txtStep4Badge").innerText = t.step4Badge;
      document.getElementById("txtStep4Title").innerText = t.step4Title;
      document.getElementById("txtStep4Desc").innerText = t.step4Desc;

      document.getElementById("txtStep5Badge").innerText = t.step5Badge;
      document.getElementById("txtStep5Title").innerText = t.step5Title;
      document.getElementById("txtStep5Desc").innerText = t.step5Desc;

      for (let i = 1; i <= 5; i++) {
        const bBack = document.getElementById("btnBack" + i);
        const bNext = document.getElementById("btnNext" + i);
        if (bBack) bBack.innerText = t.btnBack;
        if (bNext) bNext.innerText = t.btnNext;
      }
      document.getElementById("btnReset").innerText = t.btnReset;
    }

    // BACKGROUND PHOTO ROTATOR
    const bgPhotos = [
      "{{ asset('assets/galeri/foto1.jpg') }}",
      "{{ asset('assets/galeri/foto2.jpg') }}",
      "{{ asset('assets/galeri/foto3.jpg') }}",
      "{{ asset('assets/galeri/foto4.jpg') }}",
      "{{ asset('assets/galeri/foto5.jpg') }}",
      "{{ asset('assets/galeri/foto6.jpg') }}",
      "{{ asset('assets/galeri/foto7.jpg') }}"
    ];
    let bgPhotoIdx = 0;
    setInterval(() => {
      bgPhotoIdx = (bgPhotoIdx + 1) % bgPhotos.length;
      const bgEl = document.querySelector(".bg");
      if (bgEl) {
        bgEl.style.backgroundImage = `url('${bgPhotos[bgPhotoIdx]}')`;
      }
    }, 7000);

    // Close theme picker when clicking outside
    document.addEventListener("click", function(e) {
      const picker = document.querySelector(".theme-picker");
      if (picker && !picker.contains(e.target)) {
        document.getElementById("themeOptions").classList.remove("show");
      }
    });
  </script>

</body>

</html>
