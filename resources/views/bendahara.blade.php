<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bendahara - Sistem Transaksi</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --glass-bg: rgba(255, 255, 255, 0.05);
      --glass-border: rgba(255, 255, 255, 0.1);
      --glass-shadow: 0 15px 40px 0 rgba(0, 0, 0, 0.6);
      --primary: #c084fc;
      --secondary: #818cf8;
      --accent: #a78bfa;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
      color: white;
      background: #020617;
    }

    /* BACKGROUND */
    .bg {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: url("{{ asset('assets/kabinet.jpg') }}") center/cover no-repeat;
      z-index: -2;
      transform: scale(1.05);
      animation: bgPan 40s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes bgPan {
      0% {
        transform: scale(1.05) translate(0, 0);
      }
      100% {
        transform: scale(1.15) translate(-15px, -15px);
      }
    }

    /* OVERLAY */
    .overlay {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(2, 6, 23, 0.95) 100%);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      z-index: -1;
    }

    /* WATERMARK */
    body::before {
      content: "";
      position: fixed;
      top: 50%;
      left: 50%;
      width: 600px;
      height: 600px;
      background: url("{{ asset('assets/logo-katharsis.png') }}") no-repeat center;
      background-size: contain;
      transform: translate(-50%, -50%);
      opacity: 0.02;
      z-index: -1;
      pointer-events: none;
    }

    /* LOADING */
    #loading {
      position: fixed;
      width: 100%;
      height: 100%;
      background: #020617;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 999;
      transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1), visibility 1s;
    }

    .logo {
      font-size: 40px;
      font-weight: 800;
      letter-spacing: 6px;
      background: linear-gradient(to right, #818cf8, #c084fc, #a78bfa);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: pulseLogo 2.5s infinite alternate ease-in-out;
      text-shadow: 0 0 30px rgba(129, 140, 248, 0.4);
    }

    @keyframes pulseLogo {
      0% {
        filter: drop-shadow(0 0 15px rgba(129, 140, 248, 0.3));
      }
      100% {
        filter: drop-shadow(0 0 40px rgba(192, 132, 252, 0.6));
      }
    }

    /* CONTAINER */
    .container {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      perspective: 1200px;
    }

    .step-info {
      font-size: 13px;
      opacity: 0.9;
      margin-bottom: 15px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--primary);
      font-weight: 700;
      background: rgba(192, 132, 252, 0.15);
      display: inline-block;
      padding: 6px 14px;
      border-radius: 20px;
      border: 1px solid rgba(192, 132, 252, 0.3);
    }

    /* STEP */
    .step {
      display: none;
      max-width: 850px;
      width: 90%;
      opacity: 0;
      transform: translateY(60px) scale(0.9);
      transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);

      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
      border-radius: 36px;
      padding: 60px;
    }

    .step h2 {
      opacity: 0;
      transform: translateY(25px);
      animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards 0.2s;
      font-size: 38px;
      margin: 0 0 15px 0;
      color: #ffffff;
      text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    .step p {
      opacity: 0;
      transform: translateY(25px);
      animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards 0.4s;
      font-size: 18px;
      color: #cbd5e1;
      line-height: 1.7;
      margin-bottom: 40px;
      font-weight: 300;
    }

    .btn-container {
      opacity: 0;
      transform: translateY(25px);
      animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards 0.6s;
      display: flex;
      gap: 15px;
      justify-content: center;
    }

    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .active {
      display: block;
      opacity: 1;
      transform: translateY(0) scale(1);
    }

    /* TEXT */
    h1 {
      font-size: 56px;
      font-weight: 800;
      background: linear-gradient(135deg, #ffffff 0%, #94a3b8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 15px;
      letter-spacing: -1px;
    }

    /* BUTTON */
    button {
      padding: 16px 36px;
      border: none;
      border-radius: 40px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      letter-spacing: 1px;
      font-size: 16px;
      transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* BACK */
    button:first-of-type {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #e2e8f0;
    }

    button:first-of-type:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* NEXT & START */
    button:last-of-type {
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      color: white;
      box-shadow: 0 10px 25px rgba(129, 140, 248, 0.4);
    }

    button:last-of-type:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(192, 132, 252, 0.5);
      background: linear-gradient(135deg, var(--primary), var(--accent));
    }

    button:active {
      transform: scale(0.95) translateY(0);
    }

    /* PROGRESS */
    .progress {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
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
      box-shadow: 0 0 15px var(--primary), 0 0 5px var(--secondary);
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* MUSIC */
    .music-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 10;
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      border: 1px solid var(--glass-border);
      border-radius: 50%;
      width: 56px;
      height: 56px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      padding: 0;
      margin: 0;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
      transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .music-btn:hover {
      transform: translateY(-8px) rotate(15deg) scale(1.1);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(255, 255, 255, 0.2);
    }

    .typing {
      overflow: hidden;
      border-right: 4px solid var(--primary);
      white-space: nowrap;
      animation: typing 3s steps(30, end), blink-caret 0.7s infinite;
      margin: 0 auto 15px auto;
      max-width: fit-content;
      padding-right: 8px;
    }

    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }

    @keyframes blink-caret {
      50% { border-color: transparent }
    }

    /* khusus step terakhir */
    .step:last-child h2 {
      background: linear-gradient(135deg, #4ade80, #16a34a);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: none;
    }

    .step:last-child .step-img {
      animation: floatSuccess 3s ease-in-out infinite;
      filter: drop-shadow(0 20px 40px rgba(74, 222, 128, 0.4));
      border-color: rgba(74, 222, 128, 0.3);
    }

    @keyframes floatSuccess {
      0% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-15px) scale(1.05); }
      100% { transform: translateY(0) scale(1); }
    }

    .content {
      display: flex;
      align-items: center;
      gap: 60px;
      justify-content: center;
    }

    .step-img {
      width: 220px;
      padding: 25px;
      border-radius: 32px;

      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.15);

      animation: float 5s ease-in-out infinite;
      filter: drop-shadow(0 20px 35px rgba(0, 0, 0, 0.4));
      transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .step-img:hover {
      transform: scale(1.1) translateY(-10px) rotate(2deg);
      filter: drop-shadow(0 30px 50px rgba(0, 0, 0, 0.6));
      border-color: rgba(255, 255, 255, 0.3);
    }

    .text {
      text-align: left;
      max-width: 440px;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .content {
        flex-direction: column;
        text-align: center;
        gap: 40px;
      }
      .text {
        text-align: center;
      }
      .step-img {
        width: 160px;
      }
      .step {
        padding: 40px 25px;
      }
      h1 {
        font-size: 38px;
      }
    }
  </style>
</head>

<body>

  <!-- LOADING -->
  <div id="loading">
    <div class="logo">WELCOME BENDAHARA</div>
  </div>

  <div class="bg"></div>
  <div class="overlay"></div>

  <div class="progress">
    <div class="progress-bar" id="progressBar"></div>
  </div>

  <div class="container">

    <!-- STEP 0 -->
    <div class="step active">
      <h1 class="typing">Sistem Transaksi</h1>
      <p>KPM HMIT — Kabinet Katharsis</p>
      <div class="btn-container">
        <button onclick="startApp()">Mulai Sekarang</button>
      </div>
    </div>

    <!-- STEP 1 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/pengajuan.jpeg') }}" class="step-img" alt="Pengajuan">
        <div class="text">
          <p class="step-info">Step 1 of 5</p>
          <h2>Pengajuan</h2>
          <p>Komisi mengajukan kebutuhan barang sebelum pembelian</p>
          <div class="btn-container">
            <button onclick="prevStep()">← Back</button>
            <button onclick="nextStep()">Next →</button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 2 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/approval.jpeg') }}" class="step-img" alt="Approval">
        <div class="text">
          <p class="step-info">Step 2 of 5</p>
          <h2>Approval</h2>
          <p>Bendahara melakukan ACC atau Reject</p>
          <div class="btn-container">
            <button onclick="prevStep()">← Back</button>
            <button onclick="nextStep()">Next →</button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 3 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/pembelian.jpeg') }}" class="step-img" alt="Pembelian">
        <div class="text">
          <p class="step-info">Step 3 of 5</p>
          <h2>Pembelian</h2>
          <p>Komisi membeli barang sesuai pengajuan</p>
          <div class="btn-container">
            <button onclick="prevStep()">← Back</button>
            <button onclick="nextStep()">Next →</button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 4 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/nota.jpeg') }}" class="step-img" alt="Nota">
        <div class="text">
          <p class="step-info">Step 4 of 5</p>
          <h2>Nota</h2>
          <p><b>Nota wajib berisi:</b> KPM HMIT Universitas Telkom, tanggal, dan tanda tangan vendor</p>
          <div class="btn-container">
            <button onclick="prevStep()">← Back</button>
            <button onclick="nextStep()">Next →</button>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 5 -->
    <div class="step">
      <div class="content">
        <img src="{{ asset('assets/reimburse.jpeg') }}" class="step-img" alt="Reimburse">
        <div class="text">
          <p class="step-info">Step 5 of 5</p>
          <h2>Reimburse</h2>
          <p>Dana diganti setelah proses verifikasi oleh bendahara</p>
          <div class="btn-container">
            <button onclick="prevStep()">← Back</button>
            <button onclick="resetStep()">Selesai ✓</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- AUDIO -->
  <audio id="bgMusic" loop>
    <source src="{{ asset('assets/music.mp3') }}" type="audio/mpeg">
  </audio>

  <button class="music-btn" onclick="toggleMusic()">🎵</button>

  <script>
    let current = 0;
    const steps = document.querySelectorAll(".step");
    const progress = document.getElementById("progressBar");
    const music = document.getElementById("bgMusic");

    /* LOADING */
    setTimeout(() => {
      const loading = document.getElementById("loading");
      loading.style.opacity = "0";
      setTimeout(() => {
        loading.style.visibility = "hidden";
      }, 1000);
    }, 2000);

    /* STEP NAVIGATION */
    function showStep(i) {
      steps.forEach(s => s.classList.remove("active"));
      steps[i].classList.add("active");

      // RESET ANIMATIONS
      const animEls = steps[i].querySelectorAll("h2, p:not(.step-info), .btn-container");
      animEls.forEach(el => {
        el.style.animation = "none";
        el.offsetHeight; // trigger reflow
        el.style.animation = "";
      });

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
      music.play();
      nextStep();
    }

    function toggleMusic() {
      if (music.paused) {
        music.play();
      } else {
        music.pause();
      }
    }
  </script>

</body>

</html>
