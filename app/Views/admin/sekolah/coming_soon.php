<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-body text-center py-5">
    <h3 class="mb-3"><?= esc($title) ?></h3>
    <p class="text-muted">
      Modul ini sedang dalam tahap pengembangan.
    </p>
    <span class="badge bg-warning text-dark px-3 py-2">
      Coming Soon
    </span>
  </div>
</div>

<?= $this->endSection() ?>