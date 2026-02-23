<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= lang('App.verify_code') ?> | <?= lang('App.system_name') ?></title>

    <!-- GOOGLE FONT (INTER) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <!-- FONT AWESOME 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- BASE CSS (tetap dipertahankan) -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendors/typicons/typicons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/enterprise.css') ?>">

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
            overflow: hidden;
            background: radial-gradient(circle at 10% 30%, #0a1f44, #030614);
        }

        /* ===== GRADIENT OVERLAY (pengganti particles) ===== */
        .gradient-overlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 70% 20%, rgba(255, 215, 0, 0.12), transparent 60%);
            z-index: 2;
            pointer-events: none;
        }

        /* ===== WRAPPER UTAMA ===== */
        .wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ===== KARTU VERIFIKASI (GLASSMORPHISM) ===== */
        .card-verif {
            width: 100%;
            max-width: 460px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            padding: 2.8rem 2.2rem;
            transition: transform 0.3s, box-shadow 0.4s;
        }

        .card-verif:hover {
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 215, 0, 0.2) inset;
            transform: translateY(-5px);
        }

        /* ===== BRAND SECTION ===== */
        .brand {
            text-align: center;
            margin-bottom: 2.2rem;
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

        .card-verif:hover .brand-icon-wrapper i {
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
            margin-bottom: 1.8rem;
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
            transition: transform 0.2s;
        }

        .input-wrapper:focus-within {
            transform: scale(1.01);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            transition: color 0.2s;
            pointer-events: none;
            z-index: 2;
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

        /* ===== TOMBOL VERIFIKASI ===== */
        .btn-verif {
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
            margin-bottom: 1.2rem;
        }

        .btn-verif::before {
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

        .btn-verif:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-verif:hover {
            background: linear-gradient(145deg, #FFE55C, #FFC800);
            transform: translateY(-3px);
            box-shadow: 0 20px 30px -5px rgba(255, 215, 0, 0.6);
        }

        .btn-verif:active {
            transform: translateY(1px);
            box-shadow: 0 5px 15px -5px rgba(255, 215, 0, 0.5);
        }

        .btn-verif i {
            font-size: 1.2rem;
            transition: transform 0.2s;
        }

        .btn-verif:hover i {
            transform: translateX(5px);
        }

        /* loading state untuk tombol */
        .btn-verif.loading {
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

        /* ===== PROGRESS BAR ===== */
        .progress-wrapper {
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

        /* ===== LINK KIRIM ULANG (tombol bergaya link) ===== */
        .resend-link form {
            display: inline;
        }

        .resend-link button.resend-button {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 0.9rem;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
            padding-bottom: 2px;
            transition: color 0.2s, border-bottom-color 0.2s;
        }

        .resend-link button.resend-button:hover {
            color: #FFD700;
            border-bottom-color: #FFD700;
        }

        .resend-link button.resend-button i {
            margin-right: 6px;
            font-size: 0.9rem;
        }

        /* loading state untuk tombol resend (opsional) */
        .resend-button.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        /* ===== FOOTER ===== */
        .footer-note {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.8rem;
            letter-spacing: 0.3px;
        }

        .footer-note a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-bottom: 1px dotted rgba(255, 255, 255, 0.2);
        }

        .footer-note a:hover {
            color: #FFD700;
            border-bottom-color: #FFD700;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .card-verif {
                padding: 2rem 1.5rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- OVERLAY GRADIENT DINAMIS (pengganti particles) -->
    <div class="gradient-overlay"></div>

    <div class="wrapper">
        <div class="card-verif">

            <!-- BRAND -->
            <div class="brand">
                <div class="brand-icon-wrapper">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="brand-title"><?= lang('App.verify_code') ?></h1>
                <p class="brand-subtitle"><?= lang('App.enter_6_digit_code') ?></p>
            </div>

            <!-- ERROR -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <!-- VERIFY FORM -->
            <form method="post" action="<?= base_url('verify-login') ?>" id="verifyForm">
                <?= csrf_field() ?>

                <div class="form-group-custom">
                    <label class="form-label" for="code">
                        <i class="fas fa-qrcode"></i>
                        <?= lang('App.verification_code') ?>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-hashtag input-icon"></i>
                        <input type="text"
                            name="code"
                            id="code"
                            class="form-control-custom"
                            placeholder="<?= lang('App.code_placeholder') ?>"
                            maxlength="6"
                            pattern="\d*"
                            inputmode="numeric"
                            required>
                    </div>
                </div>

                <button type="submit" id="verifyBtn" class="btn-verif">
                    <i class="fas fa-check-circle"></i>
                    <span><?= lang('App.verify_button') ?></span>
                </button>

                <!-- PROGRESS -->
                <div id="progressWrapper" class="progress-wrapper d-none">
                    <div class="progress-bar-container">
                        <div id="progressBar" class="progress-bar-fill" style="width:0%"></div>
                    </div>
                    <div id="progressText" class="progress-text">
                        <i class="fas fa-spinner fa-pulse"></i>
                        <span><?= lang('App.starting_verification') ?></span>
                    </div>
                </div>
            </form>

            <!-- RESEND -->
            <div class="resend-link">
                <form method="post" action="<?= base_url('resend-code') ?>" id="resendForm">
                    <?= csrf_field() ?>
                    <button type="submit" id="resendBtn" class="resend-button">
                        <i class="fas fa-redo-alt"></i>
                        <?= lang('App.resend_code') ?>
                    </button>
                </form>
            </div>

            <div class="footer-note">
                © <?= date('Y') ?> Zulfiqri,S.Kom
            </div>

        </div>
    </div>

    <!-- BASE JS -->
    <script src="<?= base_url('assets/admin/vendors/js/vendor.bundle.base.js') ?>"></script>

    <!-- SCRIPT INTERAKSI FORM (PROGRESS BERTAHAP, LOADING) -->
    <script>
        (function() {

            const verifyForm = document.getElementById('verifyForm');
            const verifyBtn = document.getElementById('verifyBtn');
            const progressWrapper = document.getElementById('progressWrapper');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            const resendForm = document.getElementById('resendForm');
            const resendBtn = document.getElementById('resendBtn');

            if (verifyForm) {
                verifyForm.addEventListener('submit', function(e) {

                    e.preventDefault();

                    verifyBtn.disabled = true;
                    verifyBtn.classList.add('loading');
                    verifyBtn.innerHTML =
                        '<span class="spinner-custom"></span> <span><?= lang('App.processing') ?></span>';

                    progressWrapper.classList.remove('d-none');

                    progressBar.style.width = '30%';
                    progressText.innerHTML =
                        '<i class="fas fa-search"></i> <span><?= lang('App.validating_code') ?></span>';

                    setTimeout(() => {

                        progressBar.style.width = '70%';
                        progressText.innerHTML =
                            '<i class="fas fa-shield-alt"></i> <span><?= lang('App.checking_server') ?></span>';

                        setTimeout(() => {

                            progressBar.style.width = '100%';
                            progressText.innerHTML =
                                '<i class="fas fa-check-circle"></i> <span><?= lang('App.verification_success_redirect') ?></span>';

                            setTimeout(() => {
                                verifyForm.submit();
                            }, 500);

                        }, 1200);

                    }, 800);
                });
            }

            if (resendForm) {
                resendForm.addEventListener('submit', function(e) {

                    e.preventDefault();

                    resendBtn.disabled = true;
                    resendBtn.innerHTML =
                        '<i class="fas fa-spinner fa-pulse"></i> <?= lang('App.resending') ?>';

                    setTimeout(() => {
                        resendForm.submit();
                    }, 500);
                });
            }

        })();
    </script>

</body>

</html>