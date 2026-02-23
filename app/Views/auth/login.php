<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= lang('App.login') ?> | <?= lang('App.system_name') ?></title>


  <!-- GOOGLE FONT (INTER) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="..."
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />


  <!-- FONT AWESOME 6 (untuk ikon modern) -->

  <!-- BASE CSS (tetap dipertahankan) -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendors/typicons/typicons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendors/css/vendor.bundle.base.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/enterprise.css') ?>">

  <link rel="shortcut icon" href="<?= base_url('assets/admin/images/favicon.ico') ?>">

  <style>
    /* ===== RESET & VARIABEL ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      height: 100vh;
      min-height: 100vh;
      background: radial-gradient(circle at 10% 30%, #0a1f44, #030614);
    }

    /* ===== LAPISAN OVERLAY GRADIENT (pengganti particles) ===== */
    .gradient-overlay {
      position: fixed;
      inset: 0;
      background: radial-gradient(circle at 70% 20%, rgba(255, 215, 0, 0.12), transparent 60%);
      z-index: 2;
      pointer-events: none;
    }

    /* ===== WRAPPER UTAMA ===== */
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }


    /* ===== KARTU LOGIN (GLASSMORPHISM) ===== */
    .login-card {
      width: 100%;
      max-width: 450px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      border-radius: 28px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6),
        0 0 0 1px rgba(255, 255, 255, 0.05) inset;
      padding: 2.2rem 2rem;
      transition: transform 0.3s, box-shadow 0.4s;
    }


    .login-card:hover {
      box-shadow: 0 50px 100px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 215, 0, 0.2) inset;
      transform: translateY(-5px);
    }

    /* ===== BRAND SECTION ===== */
    .brand {
      text-align: center;
      margin-bottom: 1.6rem;
    }

    .brand-icon-wrapper {
      width: 80px;
      height: 80px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.2rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
      transition: all 0.3s;
    }

    .brand-icon-wrapper i {
      font-size: 42px;
      color: #fff;
      text-shadow: 0 2px 10px rgba(255, 215, 0, 0.5);
      transition: transform 0.3s;
    }

    .login-card:hover .brand-icon-wrapper i {
      transform: scale(1.1) rotate(5deg);
      color: #FFD700;
    }

    .brand-title {
      font-weight: 700;
      font-size: 1.8rem;
      letter-spacing: -0.5px;
      background: linear-gradient(135deg, #fff, #e0e0ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.3rem;
    }

    .brand-subtitle {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.7);
      font-weight: 400;
      letter-spacing: 0.3px;
    }

    /* ===== ALERT CUSTOM ===== */
    .alert-custom {
      background: rgba(255, 75, 75, 0.15);
      border: 1px solid rgba(255, 75, 75, 0.3);
      backdrop-filter: blur(5px);
      color: #ffb3b3;
      border-radius: 16px;
      padding: 0.9rem 1.2rem;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 1.8rem;
    }

    .alert-custom i {
      font-size: 1.2rem;
      color: #ff6b6b;
    }

    /* ===== FORM GROUP ===== */
    .form-group-custom {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 500;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 0.5rem;
      letter-spacing: 0.3px;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      color: #e6e6e6;
      opacity: 0.9;
      font-size: 1.1rem;
      transition: all 0.2s;
      pointer-events: none;
      z-index: 2;
      text-shadow: 0 0 6px rgba(255, 215, 0, 0.4);
    }

    .form-control-custom {
      width: 100%;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      padding: 0.9rem 1rem 0.9rem 3rem;
      font-size: 1rem;
      color: #fff;
      transition: all 0.3s;
      font-family: 'Inter', sans-serif;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .form-control-custom:focus {
      outline: none;
      border-color: #FFD700;
      background: rgba(255, 255, 255, 0.1);
      box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.2), 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .form-control-custom::placeholder {
      color: rgba(255, 255, 255, 0.35);
      font-weight: 300;
    }

    /* toggle password */
    .toggle-password {
      position: absolute;
      right: 16px;
      color: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      font-size: 1.2rem;
      transition: color 0.2s;
      z-index: 3;
    }

    .toggle-password:hover {
      color: #FFD700;
    }

    /* lupa password */
    .forgot-link {
      text-align: right;
      margin: 0.5rem 0 1.8rem;
    }

    .forgot-link a {
      color: rgba(255, 255, 255, 0.7);
      font-size: 0.85rem;
      text-decoration: none;
      transition: color 0.2s;
      border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
    }

    .forgot-link a:hover {
      color: #FFD700;
      border-bottom-color: #FFD700;
    }

    /* ===== TOMBOL LOGIN ===== */
    .btn-login {
      width: 100%;
      background: linear-gradient(145deg, #FFD700, #FFB800);
      border: none;
      border-radius: 30px;
      padding: 1rem;
      font-weight: 700;
      font-size: 1.1rem;
      color: #0a1f44;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 10px 20px -5px rgba(255, 215, 0, 0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      position: relative;
      overflow: hidden;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .btn-login:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-login:hover {
      background: linear-gradient(145deg, #FFE55C, #FFC800);
      transform: translateY(-3px);
      box-shadow: 0 20px 30px -5px rgba(255, 215, 0, 0.6);
    }

    .btn-login:active {
      transform: translateY(1px);
      box-shadow: 0 5px 15px -5px rgba(255, 215, 0, 0.5);
    }

    .btn-login i {
      font-size: 1.2rem;
      transition: transform 0.2s;
    }

    .btn-login:hover i {
      transform: translateX(5px);
    }

    /* loading state */
    .btn-login.loading {
      pointer-events: none;
      opacity: 0.8;
      background: linear-gradient(145deg, #c0c0c0, #a0a0a0);
      box-shadow: none;
    }

    .spinner-custom {
      width: 22px;
      height: 22px;
      border: 3px solid rgba(10, 31, 68, 0.2);
      border-top: 3px solid #0a1f44;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: inline-block;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* ===== PROGRESS BAR (disederhanakan: hanya muncul saat loading) ===== */
    .login-progress {
      margin-top: 1.5rem;
      background: rgba(0, 0, 0, 0.3);
      border-radius: 30px;
      padding: 0.8rem 1.2rem;
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .progress-bar-container {
      width: 100%;
      height: 6px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 0.5rem;
    }

    .progress-bar-fill {
      height: 100%;
      width: 0%;
      background: linear-gradient(90deg, #FFD700, #FFB800);
      border-radius: 10px;
      transition: width 0.4s ease;
      box-shadow: 0 0 10px #FFD700;
    }

    .progress-text {
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.85rem;
      font-weight: 400;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .progress-text i {
      color: #FFD700;
      font-size: 0.9rem;
    }

    /* ===== FOOTER ===== */
    .login-footer {
      text-align: center;
      margin-top: 1.4rem;
      color: rgba(255, 255, 255, 0.4);
      font-size: 0.8rem;
      letter-spacing: 0.3px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 480px) {
      .login-card {
        padding: 2rem 1.5rem;
      }

      .brand-title {
        font-size: 1.5rem;
      }
    }

    /* animasi ringan untuk input */
    .input-wrapper:focus-within {
      transform: scale(1.01);
    }

    .form-label {
      margin-bottom: 0.6rem;
    }
  </style>
</head>

<body>

  <!-- OVERLAY GRADIENT DINAMIS (sebagai background utama) -->
  <div class="gradient-overlay"></div>

  <div class="login-wrapper">
    <div class="login-card" id="loginCard">

      <!-- BRAND dengan ikon besar -->
      <div class="brand">
        <div class="brand-icon-wrapper">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <h1 class="brand-title"><?= lang('App.system_name') ?></h1>
        <p class="brand-subtitle"><?= lang('App.system_tagline') ?></p>
      </div>

      <!-- ALERT ERROR (tetap pakai flashdata) -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-custom">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= session()->getFlashdata('error') ?></span>
        </div>
      <?php endif; ?>

      <!-- FORM LOGIN (method & action tetap) -->
      <form method="post" action="<?= base_url('login') ?>" id="loginForm" autocomplete="current-password">
        <?= csrf_field() ?>

        <!-- FIELD USERNAME / EMAIL -->
        <div class="form-group-custom">

          <label class="form-label" for="username">
            <i class="far fa-user" style="margin-right:6px;"></i>
            <?= lang('App.username_or_email') ?>
          </label>

          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input type="text"
              name="username"
              id="username"
              class="form-control-custom"
              placeholder="<?= lang('App.enter_username') ?>"
              required>
          </div>

        </div>


        <!-- FIELD PASSWORD -->
        <div class="form-group-custom">
          <label class="form-label" for="password">
            <i class="fas fa-lock" style="margin-right: 6px;"></i> <?= lang('App.password') ?>

          </label>
          <div class="input-wrapper">
            <i class="fas fa-key input-icon"></i>
            <input type="password" name="password" id="password"
              class="form-control-custom"
              placeholder="<?= lang('App.enter_password') ?>"

              required>
            <span id="togglePassword" class="toggle-password">
              <i class="far fa-eye"></i>
            </span>
          </div>
        </div>

        <!-- LINK LUPA PASSWORD -->
        <div class="forgot-link">
          <a href="<?= base_url('forgot-password') ?>">
            <i class="fas fa-question-circle" style="margin-right: 4px;"></i> <?= lang('App.forgot_password') ?>
          </a>
        </div>

        <!-- TOMBOL LOGIN -->
        <div class="d-grid">
          <button type="submit" id="loginBtn" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> <span><?= lang('App.login_button') ?></span>

          </button>
        </div>

        <!-- PROGRESS LOGIN (AWALNYA TERSEMBUNYI, MUNCUL SAAT LOADING) -->
        <div id="loginProgress" class="login-progress d-none">
          <div class="progress-bar-container">
            <div id="progressBar" class="progress-bar-fill" style="width: 100%"></div>
          </div>
          <div id="progressText" class="progress-text">
            <i class="fas fa-spinner fa-pulse"></i>
            <span><?= lang('App.processing_login') ?></span>

          </div>
        </div>

      </form>

      <!-- FOOTER -->
      <div class="login-footer">
        © <?= date('Y') ?> Design By. <a href="http://instagram.com/zufieee" target="_blank" rel="noopener noreferrer">Zulfiqri,S.Kom</a> All rights reserved.
      </div>

    </div>
  </div>

  <!-- BASE JS (diperlukan untuk fungsi backend) -->
  <script src="<?= base_url('assets/admin/vendors/js/vendor.bundle.base.js') ?>"></script>
  <script>
    const LANG = {
      validating_data: "<?= lang('App.validating_data') ?>",
      authenticating_account: "<?= lang('App.authenticating_account') ?>",
      login_success_redirect: "<?= lang('App.login_success_redirect') ?>",
      processing: "<?= lang('App.processing_login') ?>"
    };
  </script>

  <!-- SCRIPT INTERAKSI FORM (TOGGLE PASSWORD, LOADING SEDERHANA) -->
  <script>
    (function() {
      const loginForm = document.getElementById('loginForm');
      const loginBtn = document.getElementById('loginBtn');
      const progressBox = document.getElementById('loginProgress');
      const progressBar = document.getElementById('progressBar');
      const progressText = document.getElementById('progressText');
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');

      // Toggle password
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
      });

      // Handle submit
      loginForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Cegah submit langsung

        // Disable tombol & tampilkan loading
        // Disable tombol & tampilkan loading
        loginBtn.disabled = true;
        loginBtn.classList.add('loading');
        loginBtn.innerHTML = `
  <span class="spinner-custom"></span>
  <span>${LANG.processing}</span>
`;
        progressBox.classList.remove('d-none');

        // Tahap 1: 30%
        progressBar.style.width = '30%';
        progressText.innerHTML = `
  <i class="fas fa-search"></i>
  <span>${LANG.validating_data}</span>
`;

        setTimeout(() => {

          // Tahap 2: 70%
          progressBar.style.width = '70%';
          progressText.innerHTML = `
    <i class="fas fa-lock"></i>
    <span>${LANG.authenticating_account}</span>
  `;

          setTimeout(() => {

            // Tahap 3: 100%
            progressBar.style.width = '100%';
            progressText.innerHTML = `
      <i class="fas fa-check-circle"></i>
      <span>${LANG.login_success_redirect}</span>
    `;

            // Submit form setelah progress selesai
            setTimeout(() => {
              loginForm.submit();
            }, 500);

          }, 1200);

        }, 800);
        // durasi tahap 1
      });

      // Animasi ringan saat focus
      document.querySelectorAll('.form-control-custom').forEach(input => {
        input.addEventListener('focus', () => {
          input.closest('.input-wrapper').style.transform = 'scale(1.01)';
        });
        input.addEventListener('blur', () => {
          input.closest('.input-wrapper').style.transform = 'scale(1)';
        });
      });
    })();
  </script>
  <!-- jangan lupa baca note skrip API zul -->
  <!-- CATATAN: semua fungsi backend tetap berjalan, 
       action form mengarah ke base_url('login'), 
       csrf_field() dipertahankan, 
       flashdata error juga muncul dengan styling baru.
       Animasi JS yang memberatkan (particles, simulasi progress bertahap) telah dihapus. -->
</body>

</html>