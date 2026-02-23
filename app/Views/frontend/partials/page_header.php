<?php

$request  = service('request');
$segments = $request->getUri()->getSegments();

$segment1 = $segments[0] ?? '';
$segment2 = $segments[1] ?? '';
$segment3 = $segments[2] ?? '';

$pageLabel = $pageLabel ?? null;
$pageTitle = $pageTitle ?? null;

/*
|--------------------------------------------------------------------------
| AUTO DETECT LABEL
|--------------------------------------------------------------------------
*/
if (!$pageLabel) {
    switch ($segment2) {
        case 'program-unggulan':
            $pageLabel = lang('App.program_unggulan');
            break;
        case 'jurusan':
            $pageLabel = lang('App.jurusan');
            break;
        case 'berita':
            $pageLabel = lang('App.berita');
            break;
        case 'akademik':
            $pageLabel = lang('App.akademik');
            break;
        default:
            $pageLabel = lang('App.informasi');
    }
}

/*
|--------------------------------------------------------------------------
| AUTO DETECT TITLE
|--------------------------------------------------------------------------
*/
if (!$pageTitle) {
    if ($segment3) {
        $pageTitle = ucwords(str_replace('-', ' ', $segment3));
    } elseif ($segment2) {
        $pageTitle = ucwords(str_replace('-', ' ', $segment2));
    } else {
        $pageTitle = $institutionName ?? '';
    }
}

?>

<section class="page-header-pro">
    <div class="header-overlay"></div>

    <div class="container position-relative">
        <div class="header-inner">

            <?php if (!empty($pageLabel)) : ?>
                <span class="header-label">
                    <?= strtoupper(esc((string)$pageLabel)) ?>
                </span>
            <?php endif; ?>

            <h1 class="header-title">
                <?= esc($pageTitle) ?>
            </h1>

            <div class="header-divider"></div>

            <nav class="header-breadcrumb">
                <a href="<?= base_url() ?>">
                    <i class="fas fa-home me-1"></i> Home
                </a>

                <?php if ($segment2) : ?>
                    <span class="sep">›</span>
                    <span><?= ucwords(str_replace('-', ' ', $segment2)) ?></span>
                <?php endif; ?>

                <?php if ($segment3) : ?>
                    <span class="sep">›</span>
                    <span class="current"><?= esc($pageTitle) ?></span>
                <?php endif; ?>
            </nav>

        </div>
    </div>
</section>

<style>
    /* =========================================================
   PAGE HEADER PRO – ENTERPRISE ULTRA PREMIUM
========================================================= */
    /* =========================================
   MOBILE MINIMAL MODE
========================================= */
    @media (max-width: 768px) {

        .header-label {
            display: none;
        }

        .header-breadcrumb {
            display: none;
        }

        .header-divider {
            display: none;
        }

        .page-header-pro {
            padding: 50px 0 40px;
            text-align: center;
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
            text-shadow: none;
        }
    }

    .page-header-pro {
        position: relative;
        padding: 90px 0 70px;
        background: linear-gradient(135deg, #0b1c3d 0%, #102a57 100%);
        color: #ffffff;
        overflow: hidden;
    }

    /* Overlay pattern */
    .page-header-pro::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg,
                rgba(0, 0, 0, 0.35),
                rgba(0, 0, 0, 0.15));
    }

    .header-overlay {
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.08), transparent 70%);
        top: -200px;
        right: -150px;
        pointer-events: none;
    }

    .header-inner {
        max-width: 100%;
    }

    /* LABEL */
    .header-label {
        font-size: 12px;
        letter-spacing: 2px;
        font-weight: 700;
        color: #ffd866;
    }

    /* TITLE */
    .header-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 18px;
        line-height: 1.2;
        color: #ffffff;
        text-shadow:
            0 4px 12px rgba(0, 0, 0, 0.35),
            0 0 20px rgba(255, 215, 0, 0.08);
    }

    /* DIVIDER */
    .header-divider {
        width: 70px;
        height: 4px;
        background: linear-gradient(90deg, #d4af37, #f1d37a);
        border-radius: 20px;
        margin-bottom: 20px;
    }

    /* BREADCRUMB */
    .header-breadcrumb {
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        color: rgba(255, 255, 255, 0.75);
    }

    .header-breadcrumb a {
        color: #f1d37a;
        text-decoration: none;
        font-weight: 500;
    }

    .header-breadcrumb a:hover {
        opacity: 0.85;
    }

    .header-breadcrumb .sep {
        opacity: 0.5;
    }

    .header-breadcrumb .current {
        color: #ffffff;
        font-weight: 600;
    }

    /* RESPONSIVE */

    @media (max-width: 992px) {
        .header-title {
            font-size: 30px;
        }
    }

    @media (max-width: 768px) {
        .page-header-pro {
            padding: 70px 0 50px;
            text-align: center;
        }

        .header-inner {
            margin: 0 auto;
        }

        .header-breadcrumb {
            justify-content: center;
        }

        .header-title {
            font-size: 24px;
        }

        .header-divider {
            margin: 0 auto 20px;
        }

    }

    @media (min-width: 992px) {
        .page-header-pro .header-inner {
            margin-left: -40px;
        }
    }
</style>