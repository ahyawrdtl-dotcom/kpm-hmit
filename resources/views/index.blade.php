<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal KPM HMIT — Kabinet Katharsis 2026</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: #c084fc;
      --secondary: #818cf8;
      --accent: #38bdf8;
      --bg-dark: #020617;
      --glass-bg: rgba(15, 23, 42, 0.65);
      --glass-border: rgba(255, 255, 255, 0.1);
      --glass-shadow: 0 25px 60px 0 rgba(0, 0, 0, 0.6);
      --glow-purple: rgba(192, 132, 252, 0.35);
      --glow-blue: rgba(129, 140, 248, 0.35);
    }

    /* THEME PRESETS */
    body.theme-emerald {
      --primary: #34d399;
      --secondary: #059669;
      --accent: #6ee7b7;
      --glow-purple: rgba(52, 211, 153, 0.35);
      --glow-blue: rgba(5, 150, 105, 0.35);
    }

    body.theme-cyan {
      --primary: #38bdf8;
      --secondary: #0284c7;
      --accent: #7dd3fc;
      --glow-purple: rgba(56, 189, 248, 0.35);
      --glow-blue: rgba(2, 132, 199, 0.35);
    }

    body.theme-crimson {
      --primary: #fb7185;
      --secondary: #e11d48;
      --accent: #fda4af;
      --glow-purple: rgba(251, 113, 133, 0.35);
      --glow-blue: rgba(225, 29, 72, 0.35);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: var(--bg-dark);
      color: white;
      overflow-x: hidden;
      min-height: 100vh;
      transition: background 0.5s ease;
    }

    /* ANIMATED BACKGROUND MESH */
    .bg-mesh {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
      background:
        radial-gradient(circle at 15% 30%, var(--glow-blue), transparent 45%),
        radial-gradient(circle at 85% 70%, var(--glow-purple), transparent 45%);
      animation: backgroundMove 15s infinite alternate ease-in-out;
      filter: blur(50px);
      transition: all 0.5s ease;
    }

    @keyframes backgroundMove {
      0% { transform: scale(1) translate(0, 0); }
      50% { transform: scale(1.08) translate(2%, 2%); }
      100% { transform: scale(1.15) translate(-2%, -2%); }
    }

    /* TOP TOOLBAR */
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
      font-weight: 800;
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

    /* THEME DROPDOWN */
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

    /* LOADING SCREEN WITH 7 PHOTO EXPLOSION ANIMATION */
    #loadingScreen {
      position: fixed;
      width: 100%;
      height: 100%;
      background: #020617;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      z-index: 999;
      transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
      overflow: hidden;
    }

    .photo-pop-container {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .pop-photo {
      position: absolute;
      border-radius: 20px;
      overflow: hidden;
      padding: 8px;
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7), 0 0 30px var(--glow-purple);
      opacity: 0;
      transform: scale(0) rotate(-15deg);
      animation: popZoomIn 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .pop-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 14px;
    }

    /* 7 PHOTO POSITIONS AROUND CENTER LOGO */
    .pop-photo.p1 { width: 230px; height: 160px; top: 6%; left: 5%; animation-delay: 0.1s; }
    .pop-photo.p2 { width: 200px; height: 260px; top: 5%; right: 6%; animation-delay: 0.3s; }
    .pop-photo.p3 { width: 250px; height: 160px; bottom: 6%; left: 6%; animation-delay: 0.5s; }
    .pop-photo.p4 { width: 220px; height: 160px; bottom: 7%; right: 6%; animation-delay: 0.7s; }
    .pop-photo.p5 { width: 180px; height: 240px; top: 36%; left: 2%; animation-delay: 0.9s; }
    .pop-photo.p6 { width: 180px; height: 240px; top: 33%; right: 2%; animation-delay: 1.1s; }
    .pop-photo.p7 { width: 240px; height: 150px; top: 4%; left: 37%; animation-delay: 1.3s; }

    @keyframes popZoomIn {
      0% {
        opacity: 0;
        transform: scale(0) rotate(-25deg);
        filter: blur(15px);
      }
      70% {
        opacity: 1;
        transform: scale(1.12) rotate(4deg);
        filter: blur(0px);
      }
      100% {
        opacity: 0.92;
        transform: scale(1) rotate(0deg);
        filter: blur(0px);
      }
    }

    .logo-container {
      position: relative;
      z-index: 10;
      text-align: center;
      background: rgba(2, 6, 23, 0.75);
      backdrop-filter: blur(20px);
      padding: 30px 50px;
      border-radius: 30px;
      border: 1px solid var(--glass-border);
      box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    }

    .logo {
      font-size: 42px;
      font-weight: 800;
      letter-spacing: 6px;
      background: linear-gradient(135deg, var(--secondary), var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: pulseLogo 2.5s infinite alternate ease-in-out;
      text-shadow: 0 0 40px var(--glow-purple);
    }

    .loadingText {
      margin-top: 15px;
      font-size: 13px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 500;
      animation: blink 1.5s infinite ease-in-out;
    }

    @keyframes pulseLogo {
      0% { filter: drop-shadow(0 0 15px var(--secondary)); }
      100% { filter: drop-shadow(0 0 40px var(--primary)); }
    }

    /* MAIN CONTENT */
    #mainContent {
      opacity: 0;
      visibility: hidden;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 110px 20px 40px 20px;
      transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.3s;
    }

    .header-title {
      margin-bottom: 50px;
      text-align: center;
      opacity: 0;
      transform: translateY(-30px);
      animation: slideDown 1s cubic-bezier(0.16, 1, 0.3, 1) forwards 0.5s;
    }

    .header-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 18px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid var(--glass-border);
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 2.5px;
      text-transform: uppercase;
      color: var(--primary);
      margin-bottom: 15px;
    }

    .header-title h1 {
      font-size: 46px;
      font-weight: 800;
      margin: 0;
      background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: -1px;
    }

    .header-title p {
      color: #94a3b8;
      font-size: 16px;
      margin-top: 10px;
      letter-spacing: 1px;
      font-weight: 300;
    }

    /* CARDS CONTAINER */
    .container {
      display: flex;
      gap: 35px;
      perspective: 1200px;
      flex-wrap: wrap;
      justify-content: center;
      max-width: 1200px;
    }

    /* CARD STYLING */
    .card {
      width: 320px;
      height: 440px;
      border-radius: 32px;
      padding: 35px;
      position: relative;
      cursor: pointer;
      transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
      overflow: hidden;

      background: var(--glass-bg);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);

      opacity: 0;
      transform: translateY(50px) rotateX(15deg) scale(0.95);
      animation: cardEnter 1s cubic-bezier(0.16, 1, 0.3, 1) forwards 0.8s;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .card:nth-child(2) { animation-delay: 1s; }
    .card:nth-child(3) { animation-delay: 1.2s; }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 60%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
      transform: skewX(-20deg);
      transition: 0.7s;
      z-index: 0;
    }

    .card:hover::before {
      left: 150%;
    }

    .card:hover {
      transform: translateY(-20px) scale(1.04) rotateX(0);
      border-color: rgba(255, 255, 255, 0.25);
      box-shadow: 0 30px 60px var(--glow-purple);
    }

    .card > * {
      position: relative;
      z-index: 1;
    }

    .card-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .number {
      font-size: 72px;
      font-weight: 800;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.05) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      line-height: 1;
      letter-spacing: -3px;
      transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .card:hover .number {
      transform: scale(1.15) translateX(10px);
    }

    .card-icon {
      width: 64px;
      height: 64px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      color: var(--primary);
      transition: all 0.5s ease;
    }

    .card:hover .card-icon {
      transform: rotate(10px) scale(1.1);
      background: var(--primary);
      color: #020617;
      box-shadow: 0 0 20px var(--primary);
    }

    .card-body h3 {
      font-size: 26px;
      font-weight: 800;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 8px;
    }

    .card-body p {
      font-size: 13px;
      color: #94a3b8;
      line-height: 1.6;
      font-weight: 300;
    }

    .label-btn {
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 2px;
      padding: 12px 24px;
      border-radius: 30px;
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #e2e8f0;
    }

    .card:hover .label-btn {
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      color: white;
      box-shadow: 0 10px 25px var(--glow-purple);
      border-color: transparent;
      transform: translateY(-3px);
    }

    /* ANIMATIONS */
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes cardEnter {
      from { opacity: 0; transform: translateY(80px) rotateX(20deg) scale(0.9); }
      to { opacity: 1; transform: translateY(0) rotateX(0) scale(1); }
    }

    @keyframes blink {
      0%, 100% { opacity: 0.2; }
      50% { opacity: 1; }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .header-title h1 { font-size: 32px; }
      .container { gap: 20px; }
      .card { width: 100%; height: auto; min-height: 350px; }
      .top-toolbar { top: 15px; left: 15px; right: 15px; }
      .brand-pill span { display: none; }
      .pop-photo { display: none; }
    }
  </style>
</head>

<body>

  <div class="bg-mesh" id="bgMesh"></div>

  <!-- TOP TOOLBAR -->
  <div class="top-toolbar">
    <div class="brand-pill">
      <i class="fa-solid fa-sparkles" style="color: var(--primary);"></i>
      <span id="txtPortalBrand">KPM HMIT KATHARSIS</span>
    </div>

    <div class="tools-group">
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
    </div>
  </div>

  <!-- LOADING SCREEN WITH 7 PHOTO EXPLOSION ZOOM ANIMATION -->
  <div id="loadingScreen">

    <!-- ALL 7 PHOTOS EXPLODING FROM SMALL (SCALE 0) TO BIG (SCALE 1) -->
    <div class="photo-pop-container">
      <div class="pop-photo p1">
        <img src="{{ asset('assets/galeri/foto1.jpg') }}" alt="Katharsis Photo 1">
      </div>
      <div class="pop-photo p2">
        <img src="{{ asset('assets/galeri/foto2.jpg') }}" alt="Katharsis Photo 2">
      </div>
      <div class="pop-photo p3">
        <img src="{{ asset('assets/galeri/foto3.jpg') }}" alt="Katharsis Photo 3">
      </div>
      <div class="pop-photo p4">
        <img src="{{ asset('assets/galeri/foto4.jpg') }}" alt="Katharsis Photo 4">
      </div>
      <div class="pop-photo p5">
        <img src="{{ asset('assets/galeri/foto5.jpg') }}" alt="Katharsis Photo 5">
      </div>
      <div class="pop-photo p6">
        <img src="{{ asset('assets/galeri/foto6.jpg') }}" alt="Katharsis Photo 6">
      </div>
      <div class="pop-photo p7">
        <img src="{{ asset('assets/galeri/foto7.jpg') }}" alt="Katharsis Photo 7">
      </div>
    </div>

    <!-- CENTER BRAND LOGO CONTAINER -->
    <div class="logo-container">
      <div class="logo">WELCOME KATHARSIS</div>
      <div class="loadingText" id="txtLoading">Memuat Sistem Portal...</div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div id="mainContent">
    <div class="header-title">
      <div class="header-badge">
        <i class="fa-solid fa-layer-group"></i> <span id="txtHeaderBadge">KABINET KATHARSIS 2026</span>
      </div>
      <h1 id="txtHeroTitle">Portal Layanan KPM</h1>
      <p id="txtHeroDesc">Pilih modul atau sistem layanan untuk melanjutkan</p>
    </div>

    <div class="container">

      <!-- CARD 01: SEKRETARIS -->
      <div class="card" onclick="sekretaris()">
        <div class="card-top">
          <div class="number">01</div>
          <div class="card-icon"><i class="fa-solid fa-folder-open"></i></div>
        </div>
        <div class="card-body">
          <h3 id="c1Title">Sekretaris</h3>
          <p id="c1Desc">Manajemen persuratan, arsip dokumen, dan administrasi organisasi.</p>
        </div>
        <div>
          <div class="label-btn" id="c1Btn"><i class="fa-solid fa-clock"></i> <span>Coming Soon</span></div>
        </div>
      </div>

      <!-- CARD 02: BENDAHARA -->
      <div class="card" onclick="bendahara()">
        <div class="card-top">
          <div class="number">02</div>
          <div class="card-icon"><i class="fa-solid fa-money-bill-transfer"></i></div>
        </div>
        <div class="card-body">
          <h3 id="c2Title">Bendahara</h3>
          <p id="c2Desc">Alur pengajuan anggaran, approval nota, dan klaim reimburse keuangan.</p>
        </div>
        <div>
          <div class="label-btn" id="c2Btn"><i class="fa-solid fa-arrow-right-to-bracket"></i> <span>Masuk Alur</span></div>
        </div>
      </div>

      <!-- CARD 03: MONITORING UANG KAS -->
      <div class="card" onclick="uangKas()">
        <div class="card-top">
          <div class="number">03</div>
          <div class="card-icon"><i class="fa-solid fa-chart-pie"></i></div>
        </div>
        <div class="card-body">
          <h3 id="c3Title">Uang Kas</h3>
          <p id="c3Desc">Cek status kelunasan uang kas anggota secara otomatis & realtime dari Google Sheets.</p>
        </div>
        <div>
          <div class="label-btn" id="c3Btn"><i class="fa-solid fa-bolt"></i> <span>Cek Realtime</span></div>
        </div>
      </div>

    </div>
  </div>

  <script>
    let currentLang = 'ID';

    const dict = {
      ID: {
        brand: "KPM HMIT KATHARSIS",
        theme: "Warna",
        loading: "Memuat Sistem Portal...",
        headerBadge: "KABINET KATHARSIS 2026",
        heroTitle: "Portal Layanan KPM",
        heroDesc: "Pilih modul atau sistem layanan untuk melanjutkan",

        c1Title: "Sekretaris",
        c1Desc: "Manajemen persuratan, arsip dokumen, dan administrasi organisasi.",
        c1Btn: "Coming Soon",

        c2Title: "Bendahara",
        c2Desc: "Alur pengajuan anggaran, approval nota, dan klaim reimburse keuangan.",
        c2Btn: "Masuk Alur",

        c3Title: "Uang Kas",
        c3Desc: "Cek status kelunasan uang kas anggota secara otomatis & realtime dari Google Sheets.",
        c3Btn: "Cek Realtime",
        msgSekretaris: "Fitur Sekretaris belum tersedia 😄"
      },
      EN: {
        brand: "KPM HMIT KATHARSIS",
        theme: "Theme",
        loading: "Loading Portal System...",
        headerBadge: "KATHARSIS CABINET 2026",
        heroTitle: "KPM Service Portal",
        heroDesc: "Select a module or service system to proceed",

        c1Title: "Secretary",
        c1Desc: "Correspondence management, document archives, and organizational admin.",
        c1Btn: "Coming Soon",

        c2Title: "Treasurer",
        c2Desc: "Budget submission workflow, receipt approval, and financial reimbursement.",
        c2Btn: "Enter Flow",

        c3Title: "Member Dues",
        c3Desc: "Check member dues payment status automatically & realtime from Google Sheets.",
        c3Btn: "Check Real-time",
        msgSekretaris: "Secretary feature is coming soon 😄"
      }
    };

    // LOADING → MASUK MENU
    window.onload = function () {
      setTimeout(() => {
        const loadingScreen = document.getElementById("loadingScreen");
        const mainContent = document.getElementById("mainContent");

        loadingScreen.style.opacity = "0";

        setTimeout(() => {
          loadingScreen.style.visibility = "hidden";
          mainContent.style.opacity = "1";
          mainContent.style.visibility = "visible";
        }, 800);

      }, 2800); // Durasi loading untuk menikmati animasi pop-up foto
    }

    // REDIRECTION BUTTONS
    function sekretaris() {
      alert(dict[currentLang].msgSekretaris);
    }

    function bendahara() {
      document.getElementById("mainContent").style.opacity = "0";
      setTimeout(() => {
        window.location.href = "{{ route('bendahara') }}";
      }, 400);
    }

    function uangKas() {
      document.getElementById("mainContent").style.opacity = "0";
      setTimeout(() => {
        window.location.href = "{{ route('kas') }}";
      }, 400);
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

      document.getElementById("txtPortalBrand").innerText = t.brand;
      document.getElementById("txtTheme").innerText = t.theme;
      document.getElementById("txtLoading").innerText = t.loading;
      document.getElementById("txtHeaderBadge").innerText = t.headerBadge;
      document.getElementById("txtHeroTitle").innerText = t.heroTitle;
      document.getElementById("txtHeroDesc").innerText = t.heroDesc;

      document.getElementById("c1Title").innerText = t.c1Title;
      document.getElementById("c1Desc").innerText = t.c1Desc;
      document.getElementById("c1Btn").innerHTML = `<i class="fa-solid fa-clock"></i> <span>${t.c1Btn}</span>`;

      document.getElementById("c2Title").innerText = t.c2Title;
      document.getElementById("c2Desc").innerText = t.c2Desc;
      document.getElementById("c2Btn").innerHTML = `<i class="fa-solid fa-arrow-right-to-bracket"></i> <span>${t.c2Btn}</span>`;

      document.getElementById("c3Title").innerText = t.c3Title;
      document.getElementById("c3Desc").innerText = t.c3Desc;
      document.getElementById("c3Btn").innerHTML = `<i class="fa-solid fa-bolt"></i> <span>${t.c3Btn}</span>`;
    }

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
