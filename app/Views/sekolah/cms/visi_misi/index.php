<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="mb-0 d-flex align-items-center">
            <i class="typcn typcn-eye-outline text-primary me-2"></i>
            Visi & Misi Sekolah
        </h4>

        <span class="text-muted small">
            CMS Website Sekolah
        </span>
    </div>

    <!-- ================= ALERT ================= -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <!-- ================= FORM CARD ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="post"
                action="<?= base_url('sekolah/visi-misi/save') ?>">
                <?= csrf_field() ?>

                <!-- VISI -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-lightbulb me-1 text-muted"></i>
                        Visi Sekolah
                    </label>
                    <textarea name="visi"
                        rows="5"
                        class="form-control"
                        placeholder="Tuliskan visi sekolah..."><?= esc($data['visi'] ?? '') ?></textarea>
                </div>

                <!-- MISI -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-tick-outline me-1 text-muted"></i>
                        Misi Sekolah
                    </label>
                    <textarea name="misi"
                        rows="7"
                        class="form-control"
                        placeholder="Tuliskan misi sekolah..."><?= esc($data['misi'] ?? '') ?></textarea>
                </div>

                <!-- ACTION -->
                <div class="mt-4 text-end">
                    <button class="btn btn-primary px-4">
                        <i class="typcn typcn-save me-1"></i>
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>