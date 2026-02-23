<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <!-- ================= HEADER ================= -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="typcn typcn-home-outline me-2"></i>
                <h4 class="mb-0">Profil Yayasan</h4>
            </div>
        </div>

        <!-- ================= ALERT ================= -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ================= PROFIL YAYASAN ================= -->
        <div class="card mb-4">
            <div class="card-body">
                <?= $this->include('admin/yayasan/profil/form') ?>
            </div>
        </div>

        <!-- ================= GANTI PASSWORD ================= -->
        <div class="card mb-5">
            <div class="card-header bg-primary d-flex align-items-center">
                <i class="typcn typcn-lock-closed-outline me-2"></i>
                <h5 class="mb-0">Ganti Password Akun</h5>
            </div>

            <div class="card-body">
                <form method="post" action="<?= base_url('admin/yayasan/profil/ganti-password') ?>">
                    <?= csrf_field() ?>

                    <div class="row">
                        <!-- Password Lama -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Password Lama</label>
                            <div class="input-group">
                                <input type="password" id="password_lama" name="password_lama" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password_lama', this)">👁️</button>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <div class="input-group">
                                <input type="password" id="password_baru" name="password_baru" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password_baru', this)">👁️</button>
                            </div>
                        </div>

                        <!-- Konfirmasi -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" id="password_konfirmasi" name="password_konfirmasi" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password_konfirmasi', this)">👁️</button>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary px-4">
                            <i class="typcn typcn-key-outline me-1"></i>
                            Ganti Password
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<!-- ================= TOGGLE PASSWORD ================= -->
<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.innerHTML = input.type === 'password' ? '👁️' : '🙈';
    }
</script>

<?= $this->endSection() ?>