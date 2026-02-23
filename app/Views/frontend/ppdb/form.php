<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">

    <!-- ================= HEADER ================= -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Form Pendaftaran PPDB</h2>
        <p class="text-muted">
            Silakan isi data dengan lengkap dan benar
        </p>
    </div>

    <!-- ================= ALERT SUCCESS ================= -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center shadow-sm">
            <strong>Pendaftaran Berhasil!</strong><br>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- ================= ALERT ERROR ================= -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
                <div><?= esc($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- 🔥 JANGAN TAMPILKAN FORM JIKA SUDAH SUKSES -->
    <?php if (!session()->getFlashdata('success')): ?>

        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">

                <form method="post" action="<?= current_url() ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ppdb_id" value="<?= $ppdb['id'] ?>">

                    <!-- ================= DATA PRIBADI ================= -->
                    <h5 class="fw-bold mb-3 text-primary">Data Pribadi</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text"
                                name="nama_lengkap"
                                class="form-control"
                                value="<?= old('nama_lengkap') ?>"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text"
                                name="nisn"
                                class="form-control"
                                value="<?= old('nisn') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text"
                                name="tempat_lahir"
                                class="form-control"
                                value="<?= old('tempat_lahir') ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="<?= old('tanggal_lahir') ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat"
                            rows="3"
                            class="form-control"><?= old('alamat') ?></textarea>
                    </div>

                    <hr>

                    <!-- ================= DATA KONTAK ================= -->
                    <h5 class="fw-bold mb-3 text-primary">Data Kontak</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor HP / WhatsApp *</label>
                            <input type="text"
                                name="no_hp"
                                class="form-control"
                                value="<?= old('no_hp') ?>"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                name="email"
                                class="form-control"
                                value="<?= old('email') ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- ================= DATA ASAL SEKOLAH ================= -->
                    <h5 class="fw-bold mb-3 text-primary">Data Asal Sekolah</h5>

                    <div class="mb-4">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text"
                            name="asal_sekolah"
                            class="form-control"
                            value="<?= old('asal_sekolah') ?>">
                    </div>

                    <!-- ================= SUBMIT ================= -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-lg btn-primary px-5">
                            Kirim Pendaftaran
                        </button>
                    </div>

                </form>

            </div>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>