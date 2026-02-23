<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>
<?= view('frontend/partials/page_header', [
    'pageLabel' => 'Pendaftaran',
    'pageTitle' => 'Penerimaan Peserta Didik Baru ' . $institutionName

]) ?>

<div class="container py-5">

    <!-- ================= HERO TITLE ================= -->
  

    <!-- ================= MODE YAYASAN ================= -->
    <?php if ($type === 'yayasan'): ?>

        <div class="card border-0 shadow-sm text-center p-5">
            <div class="mb-3">
                <i class="bi bi-building display-4 text-primary"></i>
            </div>
            <h5 class="fw-bold">Informasi PPDB Yayasan</h5>
            <p class="text-muted mb-0">
                Silakan pilih unit pendidikan (TK / SD / SMP / SMA / SMK)
                untuk melihat informasi PPDB masing-masing sekolah.
            </p>
        </div>

        <!-- ================= MODE SEKOLAH TANPA PPDB ================= -->
    <?php elseif (empty($ppdb)): ?>

        <div class="card border-0 shadow-sm text-center p-5">
            <div class="mb-3">
                <i class="bi bi-calendar-x display-4 text-warning"></i>
            </div>
            <h5 class="fw-bold">PPDB Belum Dibuka</h5>
            <p class="text-muted mb-0">
                Informasi PPDB untuk sekolah ini belum tersedia.
                Silakan hubungi pihak sekolah untuk informasi lebih lanjut.
            </p>
        </div>

        <!-- ================= MODE SEKOLAH - PPDB AKTIF ================= -->
    <?php else: ?>

        <div class="card border-0 shadow-lg overflow-hidden">

            <!-- BANNER -->
            <?php if (!empty($ppdb['banner'])): ?>
                <div style="position:relative;">
                    <img
                        src="<?= base_url('uploads/ppdb/' . $context['sekolah_id'] . '/' . $ppdb['banner']) ?>"
                        class="w-100"
                        style="height:380px;object-fit:cover;"
                        alt="Banner PPDB">

                    <!-- Overlay -->
                    <div style="
                        position:absolute;
                        top:0;
                        left:0;
                        width:100%;
                        height:100%;
                        background:linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        color:#fff;
                        text-align:center;
                        padding:20px;">
                        <div>
                            <h2 class="fw-bold">
                                <?= esc($ppdb['judul']) ?>
                            </h2>
                            <p class="mb-0">
                                Tahun Ajaran <?= esc($ppdb['tahun_ajaran']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card-body p-5">

                <!-- INFO GRID -->
                <div class="row text-center mb-4">

                    <div class="col-md-4 mb-3">
                        <div class="p-3 border rounded">
                            <div class="fw-bold text-primary">Tanggal Mulai</div>
                            <?= date('d M Y', strtotime($ppdb['tanggal_mulai'])) ?>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="p-3 border rounded">
                            <div class="fw-bold text-danger">Tanggal Selesai</div>
                            <?= date('d M Y', strtotime($ppdb['tanggal_selesai'])) ?>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="p-3 border rounded">
                            <div class="fw-bold text-success">Status</div>
                            <?php
                            $today = date('Y-m-d');
                            if ($today < $ppdb['tanggal_mulai']) {
                                echo '<span class="badge bg-secondary">Belum Dimulai</span>';
                            } elseif ($today > $ppdb['tanggal_selesai']) {
                                echo '<span class="badge bg-danger">Sudah Ditutup</span>';
                            } else {
                                echo '<span class="badge bg-success">Sedang Dibuka</span>';
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <hr>

                <!-- DESKRIPSI -->
                <div class="mb-4">
                    <?= nl2br(esc((string)$ppdb['deskripsi'])) ?>
                </div>

                <!-- CTA BUTTON -->
                <?php if (date('Y-m-d') >= $ppdb['tanggal_mulai'] && date('Y-m-d') <= $ppdb['tanggal_selesai']) : ?>
                    <div class="text-center mt-4">
                        <a href="<?= current_url() ?>/daftar"
                            class="btn btn-lg btn-primary px-5">
                            Daftar Sekarang
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>