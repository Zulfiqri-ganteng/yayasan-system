<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Yayasan Persada Plus Galajuara') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png"
        href="<?= base_url($favicon ?? 'theme/img/default.png') . '?v=' . filemtime(FCPATH . ($favicon ?? 'theme/img/default.png')) ?>">

    <!-- Google Fonts (ORIGINAL THEME) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('theme/lib/animate/animate.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/lib/owlcarousel/assets/owl.carousel.min.css') ?>" rel="stylesheet">

    <!-- Bootstrap (THEME VERSION) -->
    <link href="<?= base_url('theme/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Theme Stylesheet -->
    <link href="<?= base_url('theme/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/navbar.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/fasilitas.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/galeri.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/tentang.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/footer.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/home.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/kontak.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/pengumuman.css') ?>" rel="stylesheet">
    <link href="<?= base_url('theme/webpublic/berita.css') ?>" rel="stylesheet">


</head>

<body>

    <?= $this->include('frontend/partials/navbar') ?>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('frontend/partials/footer') ?>
    <!-- Scroll To Top -->
    <button id="scrollTopBtn">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url('theme/lib/wow/wow.min.js') ?>"></script>
    <script src="<?= base_url('theme/lib/easing/easing.min.js') ?>"></script>
    <script src="<?= base_url('theme/lib/waypoints/waypoints.min.js') ?>"></script>
    <script src="<?= base_url('theme/lib/owlcarousel/owl.carousel.min.js') ?>"></script>

    <!-- Template Javascript -->
    <script src="<?= base_url('theme/js/main.js') ?>"></script>
    <script src="<?= base_url('theme/webpublic/navbar.js') ?>"></script>
    <script src="<?= base_url('theme/webpublic/home.js') ?>"></script>

    <script src="<?= base_url('theme/webpublic/staff.js') ?>"></script>
    <script src="<?= base_url('theme/webpublic/fasilitas.js') ?>"></script>
    <script src="<?= base_url('theme/webpublic/galeri.js') ?>"></script>
    <script src="<?= base_url('theme/webpublic/tentang.js') ?>"></script>
    <script src="<?= base_url('theme/webpublic/berita.js') ?>"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        // counter animation
        document.querySelectorAll('.counter').forEach(counter => {
            counter.innerText = '0';
            const updateCounter = () => {
                const target = +counter.getAttribute('data-target');
                const c = +counter.innerText;
                const increment = target / 100;

                if (c < target) {
                    counter.innerText = `${Math.ceil(c + increment)}`;
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCounter();
        });
    </script>
</body>

</html>