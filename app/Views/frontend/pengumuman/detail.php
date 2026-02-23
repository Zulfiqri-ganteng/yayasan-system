<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$type    = $context['type'];
$jenjang = $context['jenjang'] ?? null;

$tanggal = !empty($pengumuman['tanggal_publish'])
    ? date('d F Y', strtotime($pengumuman['tanggal_publish']))
    : '-';
?>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.informasi'),
    'pageTitle' => esc($pengumuman['judul'])
]) ?>

<section class="pengumuman-detail-section">
    <div class="container">

        <!-- ================= META ================= -->
        <div class="detail-meta">
            <?= lang('App.published_on') ?>:
            <?= esc($tanggal) ?>
        </div>

        <!-- ================= ATTACHMENT ================= -->
        <?php if (!empty($pengumuman['file'])): ?>
            <div class="detail-attachment">
                <a href="<?= base_url('uploads/pengumuman/' . $pengumuman['file']) ?>"
                    target="_blank"
                    class="btn-attachment">

                    <i class="fas fa-paperclip"></i>
                    <?= lang('App.view_download_attachment') ?>
                </a>
            </div>
        <?php endif ?>

        <!-- ================= CONTENT ================= -->
        <div class="detail-content">
            <?= $pengumuman['isi'] ?>
        </div>

        <br>

        <!-- ================= BACK BUTTON ================= -->
        <a href="<?= base_url(
                        $type === 'sekolah'
                            ? $jenjang . '/pengumuman'
                            : 'pengumuman'
                    ) ?>"
            class="btn-kembali">

            ← <?= lang('App.back_to_announcements') ?>
        </a>

    </div>
</section>

<?= $this->endSection() ?>