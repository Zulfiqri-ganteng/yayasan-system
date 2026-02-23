<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$type      = $context['type'];
$sekolah   = $context['sekolah'] ?? null;
$jenjang   = $context['jenjang'] ?? null;
?>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.informasi'),
    'pageTitle' => lang('App.announcement_of', ['name' => $institutionName])
]) ?>

<section class="pengumuman-section">
    <div class="container">

        <!-- ================= EMPTY STATE ================= -->
        <?php if (empty($pengumuman)): ?>
            <div class="pengumuman-empty">
                <?= lang('App.no_announcements') ?>
            </div>
        <?php endif ?>

        <!-- ================= LIST ================= -->
        <?php foreach ($pengumuman as $item): ?>
            <div class="pengumuman-card">

                <!-- Judul -->
                <h5>
                    <?= esc($item['judul']) ?>
                </h5>

                <!-- Ringkasan -->
                <p>
                    <?= esc(word_limiter(strip_tags($item['isi']), 25)) ?>
                </p>

                <!-- Footer -->
                <div class="pengumuman-footer">
                    <a href="<?= base_url(
                                    $type === 'sekolah'
                                        ? $jenjang . '/pengumuman/' . $item['id']
                                        : 'pengumuman/' . $item['id']
                                ) ?>"
                        class="btn-pengumuman">

                        <span><?= lang('App.read_more') ?></span>
                    </a>
                </div>

            </div>
        <?php endforeach ?>

    </div>
</section>

<?= $this->endSection() ?>