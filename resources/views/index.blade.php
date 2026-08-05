<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KPM HMIT</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --glass-bg: rgba(255, 255, 255, 0.03);
      --glass-border: rgba(255, 255, 255, 0.08);
      --glass-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.5);
      --glow-purple: rgba(192, 132, 252, 0.3);
      --glow-blue: rgba(129, 140, 248, 0.3);
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at 80% 20%, #1e1b4b, #0f172a 40%, #020617 80%);
      color: white;
      overflow: hidden;
      height: 100vh;
    }

    /* Animated Background Mesh */
    .bg-mesh {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
      background:
        radial-gradient(circle at 15% 50%, var(--glow-blue), transparent 30%),
        radial-gradient(circle at 85% 30%, var(--glow-purple), transparent 30%);
      animation: backgroundMove 15s infinite alternate ease-in-out;
      filter: blur(40px);
    }

    @keyframes backgroundMove {
      0% {
        transform: scale(1) translate(0, 0);
      }
      50% {
        transform: scale(1.05) translate(2%, 2%);
      }
      100% {
        transform: scale(1.1) translate(-2%, -2%);
      }
    }

    /* ================= LOADING SCREEN ================= */
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
      transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1), visibility 1s;
    }

    .logo {
      font-size: 40px;
      font-weight: 800;
      letter-spacing: 6px;
      background: linear-gradient(135deg, #a78bfa, #c084fc, #818cf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: fadeIn 2s ease forwards, pulseLogo 3s infinite alternate;
      text-shadow: 0 0 30px rgba(167, 139, 250, 0.4);
    }

    .loadingText {
      margin-top: 20px;
      font-size: 13px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 500;
      animation: blink 1.5s infinite ease-in-out;
    }

    @keyframes pulseLogo {
      0% {
        filter: drop-shadow(0 0 15px rgba(129, 140, 248, 0.3));
      }
      100% {
        filter: drop-shadow(0 0 35px rgba(192, 132, 252, 0.6));
      }
    }

    /* ================= MAIN CONTENT ================= */
    #mainContent {
      opacity: 0;
      visibility: hidden;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1) 0.5s;
    }

    .header-title {
      margin-bottom: 60px;
      text-align: center;
      opacity: 0;
      transform: translateY(-30px);
      animation: slideDown 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards 1s;
    }

    .header-title h1 {
      font-size: 48px;
      font-weight: 800;
      margin: 0;
      background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: -1px;
      text-shadow: 0 4px 20px rgba(255,255,255,0.1);
    }

    .header-title p {
      color: #94a3b8;
      font-size: 16px;
      margin-top: 10px;
      letter-spacing: 1.5px;
      font-weight: 300;
    }

    .container {
      display: flex;
      gap: 60px;
      perspective: 1200px;
    }

    /* CARD */
    .card {
      width: 290px;
      height: 420px;
      border-radius: 28px;
      padding: 35px;
      position: relative;
      cursor: pointer;
      transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
      overflow: hidden;

      /* Glassmorphism */
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);

      /* Initial Entry Animation */
      opacity: 0;
      transform: translateY(50px) rotateX(15deg) scale(0.95);
      animation: cardEnter 1s cubic-bezier(0.16, 1, 0.3, 1) forwards 1.2s;
    }

    .card:nth-child(2) {
      animation-delay: 1.4s;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
      transform: skewX(-20deg);
      transition: 0.7s;
      z-index: 0;
    }

    .card:hover::before {
      left: 150%;
    }

    .card:hover {
      transform: translateY(-20px) scale(1.05) rotateX(0);
      border-color: rgba(255, 255, 255, 0.2);
    }

    .card.blue:hover {
      box-shadow: 0 25px 50px rgba(14, 165, 233, 0.25), inset 0 0 25px rgba(14, 165, 233, 0.15);
      border-color: rgba(14, 165, 233, 0.5);
    }

    .card.purple:hover {
      box-shadow: 0 25px 50px rgba(124, 58, 237, 0.25), inset 0 0 25px rgba(124, 58, 237, 0.15);
      border-color: rgba(124, 58, 237, 0.5);
    }

    .card > * {
      position: relative;
      z-index: 1;
    }

    .number {
      font-size: 80px;
      font-weight: 800;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.05) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      line-height: 1;
      margin-bottom: 25px;
      transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
      letter-spacing: -3px;
    }

    .card:hover .number {
      transform: scale(1.15) translateX(15px);
      text-shadow: 0 10px 20px rgba(255,255,255,0.1);
    }

    .title {
      font-size: 28px;
      font-weight: 600;
      letter-spacing: 1.5px;
      text-transform: uppercase;
    }

    .label {
      position: absolute;
      bottom: 35px;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 2.5px;
      padding: 10px 20px;
      border-radius: 25px;
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .card:hover .label {
      background: rgba(255, 255, 255, 0.95);
      color: #020617;
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.4);
      border-color: transparent;
    }

    .card img {
      width: 240px;
      position: absolute;
      right: -40px;
      top: 110px;
      transform: rotate(-15deg);
      pointer-events: none;
      transition: 0.8s cubic-bezier(0.16, 1, 0.3, 1);
      filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.6));
    }

    .card:hover img {
      transform: rotate(-5deg) scale(1.15) translateY(-15px) translateX(-10px);
      filter: drop-shadow(0 30px 40px rgba(0, 0, 0, 0.8));
    }

    /* ANIMATIONS */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes cardEnter {
      from {
        opacity: 0;
        transform: translateY(80px) rotateX(20deg) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) rotateX(0) scale(1);
      }
    }

    @keyframes blink {
      0%, 100% {
        opacity: 0.2;
      }
      50% {
        opacity: 1;
      }
    }
  </style>
</head>

<body>

  <div class="bg-mesh"></div>

  <!-- LOADING -->
  <div id="loadingScreen">
    <div class="logo">WELCOME KATHARSIS</div>
    <div class="loadingText">Loading System...</div>
  </div>

  <!-- MAIN -->
  <div id="mainContent">
    <div class="header-title">
      <h1>Portal KPM</h1>
      <p>Pilih role Anda untuk melanjutkan</p>
    </div>

    <div class="container">

      <!-- SEKRETARIS -->
      <div class="card blue" onclick="sekretaris()">
        <div class="number">01</div>
        <div class="title">SEKRETARIS</div>
        <img src="https://cdn-icons-png.flaticon.com/512/2922/2922561.png" alt="Sekretaris Icon">
        <div class="label">Coming Soon</div>
      </div>

      <!-- BENDAHARA -->
      <div class="card purple" onclick="bendahara()">
        <div class="number">02</div>
        <div class="title">BENDAHARA</div>
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" alt="Bendahara Icon">
        <div class="label">Masuk</div>
      </div>

    </div>
  </div>

  <script>
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
        }, 1000);

      }, 2500); // durasi loading
    }

    // BUTTON
    function sekretaris() {
      alert("Fitur Sekretaris belum tersedia 😄");
    }

    function bendahara() {
      // Add a smooth exit animation before redirecting
      document.getElementById("mainContent").style.opacity = "0";
      setTimeout(() => {
        window.location.href = "{{ route('bendahara') }}";
      }, 500);
    }
  </script>

</body>

</html>
