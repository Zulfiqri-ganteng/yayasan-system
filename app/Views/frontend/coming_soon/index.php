<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
// gunakan partial page header agar konsisten
echo view('frontend/partials/page_header', [
    'pageLabel' => 'Akademik',
    'pageTitle' => esc($fitur)
]);
?>

<section class="coming-section">
    <div class="container">

        <div class="coming-card">

            <div class="coming-icon">
                <div class="icon-circle">
                    🚀
                </div>
            </div>

            <h2 class="coming-heading">
                <?= esc($fitur) ?> Segera Hadir
            </h2>

            <p class="coming-highlight">
                Halaman ini sedang dalam tahap pengembangan.
            </p>

            <p class="coming-text">
                Kami sedang menyiapkan sistem dan informasi terbaik
                untuk mendukung kebutuhan akademik secara profesional
                dan terintegrasi.
                <br><br>
                Silakan kunjungi kembali dalam pembaruan berikutnya.
            </p>

            <div class="coming-actions">
                <a href="javascript:history.back()" class="btn-outline">
                    ← Kembali
                </a>
            </div>

        </div>

    </div>
</section>

<style>
    /* ==============================
   PREMIUM COMING SOON PAGE
============================== */

    .coming-section {
        padding: 120px 0;
        background: #f5f7fb;
        min-height: 60vh;
    }

    .coming-card {
        max-width: 820px;
        margin: auto;
        background: #ffffff;
        padding: 80px 60px;
        border-radius: 24px;
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.07);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .icon-circle {
        width: 90px;
        height: 90px;
        margin: 0 auto 30px auto;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a2b4c, #243f7a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: #ffffff;
    }

    .coming-heading {
        font-size: 36px;
        font-weight: 700;
        color: #1a2b4c;
        margin-bottom: 15px;
    }

    .coming-highlight {
        font-size: 18px;
        font-weight: 600;
        color: #d4af37;
        margin-bottom: 20px;
    }

    .coming-text {
        font-size: 16px;
        color: #6b7280;
        line-height: 1.8;
        max-width: 620px;
        margin: 0 auto 35px auto;
    }

    .btn-outline {
        display: inline-block;
        padding: 12px 30px;
        border-radius: 40px;
        border: 2px solid #1a2b4c;
        color: #1a2b4c;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .btn-outline:hover {
        background: #1a2b4c;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* ================= MOBILE ================= */

    @media (max-width: 768px) {

        .coming-card {
            padding: 50px 30px;
        }

        .coming-heading {
            font-size: 26px;
        }

    }
</style>

<?= $this->endSection() ?>