<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid dashboard-container px-lg-4 px-2">

  <!-- ================= HEADER ================= -->
  <div class="dashboard-header">

    <div>
      <h3 class="dashboard-title">
        Executive Control Panel
      </h3>
      <p class="dashboard-subtitle">
        Centralized Monitoring & System Governance — Yayasan Galajuara
      </p>
    </div>

    <div class="dashboard-clock">
      <i class="typcn typcn-time me-1"></i>
      <span id="clock"></span>
    </div>

  </div>

  <!-- ================= KPI ================= -->
  <div class="row kpi-wrapper">

    <div class="col-6 col-md-3 mb-3">
      <a href="<?= base_url('admin/data-sekolah') ?>" class="kpi-card-link">
        <div class="card kpi-card h-100">
          <div class="card-body">
            <div class="kpi-label">Total Sekolah</div>
            <div class="kpi-value"><?= $totalSekolah ?></div>
            <div class="kpi-meta text-success">
              <?= $totalSekolahAktif ?> aktif
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-3 mb-3">
      <a href="<?= base_url('admin/users') ?>" class="kpi-card-link">
        <div class="card kpi-card h-100">
          <div class="card-body">
            <div class="kpi-label">Admin Sekolah</div>
            <div class="kpi-value"><?= $totalAdmin ?></div>
            <div class="kpi-meta">Total akun aktif</div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-3 mb-3">
      <a href="<?= base_url('admin/cms/berita') ?>" class="kpi-card-link">
        <div class="card kpi-card h-100">
          <div class="card-body">
            <div class="kpi-label">Berita Publish</div>
            <div class="kpi-value"><?= $totalBerita ?></div>
            <div class="kpi-meta">Konten aktif</div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-3 mb-3">
      <a href="<?= base_url('admin/master-fitur') ?>" class="kpi-card-link">
        <div class="card kpi-card h-100">
          <div class="card-body">
            <div class="kpi-label">Total Fitur Sistem</div>
            <div class="kpi-value"><?= $totalFitur ?></div>
            <div class="kpi-meta">Feature registry</div>
          </div>
        </div>
      </a>
    </div>

  </div>

  <!-- ================= MAIN ================= -->
  <div class="row mt-2">

    <!-- AUDIT -->
    <div class="col-lg-7 mb-3">
      <div class="card modern-card h-100">
        <div class="card-header">
          <h6>System Activity Log</h6>
        </div>

        <div class="card-body p-0">
          <ul class="list-group list-group-flush activity-list">

            <?php if (!empty($auditLogs)): ?>
              <?php foreach ($auditLogs as $log): ?>
                <li class="list-group-item activity-item">
                  <div>
                    <strong><?= esc($log['username'] ?? 'System') ?></strong>
                    <div class="small text-muted"><?= esc($log['aksi']) ?></div>
                  </div>
                  <span class="activity-time">
                    <?= date('d M Y H:i', strtotime($log['created_at'])) ?>
                  </span>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="list-group-item text-center text-muted">
                No recent activity
              </li>
            <?php endif; ?>

          </ul>
        </div>
      </div>
    </div>

    <!-- STATUS -->
    <div class="col-lg-5 mb-3">
      <div class="card modern-card h-100">
        <div class="card-header">
          <h6>Infrastructure Status</h6>
        </div>

        <div class="card-body">

          <div class="status-item">
            <span>Server Status</span>
            <span class="badge bg-success">Online</span>
          </div>

          <div class="status-item">
            <span>Database</span>
            <span class="badge bg-success">Operational</span>
          </div>

          <div class="status-item">
            <span>PPDB Aktif</span>
            <span class="badge bg-primary"><?= $ppdbAktif ?></span>
          </div>

          <div class="status-item">
            <span>Total Staff Aktif</span>
            <span class="badge bg-dark"><?= $staffAktif ?></span>
          </div>

          <hr>

          <div class="fw-semibold mb-2">Storage Utilization</div>

          <div class="small text-muted mb-2">
            <?= $usedSpace ?> / <?= $totalSpace ?>
          </div>

          <div class="progress modern-progress">
            <div class="progress-bar"
              style="width:<?= $storagePercent ?>%">
            </div>
          </div>

          <small class="text-muted mt-2 d-block">
            <?= $storagePercent ?>% capacity used
          </small>

        </div>
      </div>
    </div>

  </div>

</div>

<script>
  function updateClock() {
    const now = new Date();
    document.getElementById('clock').innerHTML =
      now.toLocaleDateString('id-ID') + ' ' +
      now.toLocaleTimeString('id-ID');
  }
  setInterval(updateClock, 1000);
  updateClock();
</script>

<style>
  /* ================= GLOBAL WIDTH FIX KHUSUS DASHBOARD ================= */

  .dashboard-container {
    padding-top: 1rem;
  }

  /* override bootstrap gutter agar tidak terlalu sempit */
  .dashboard-container .row {
    --bs-gutter-x: 0.8rem;
  }

  /* ================= HEADER ================= */

  .dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.8rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .dashboard-title {
    font-weight: 700;
    margin-bottom: 4px;
  }

  .dashboard-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 0;
  }

  .dashboard-clock {
    background: #f8f9fa;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
  }

  /* ================= KPI ================= */

  .kpi-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    transition: all .25s ease;
  }

  .kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08);
  }

  .kpi-label {
    font-size: 13px;
    color: #6c757d;
  }

  .kpi-value {
    font-size: 26px;
    font-weight: 700;
    margin-top: 4px;
  }

  .kpi-meta {
    font-size: 12px;
  }

  .kpi-card-link {
    text-decoration: none;
    color: inherit;
  }

  /* ================= CARD ================= */

  .modern-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
  }

  .modern-card .card-header {
    background: transparent;
    border: none;
    padding: 18px 20px 0 20px;
    font-weight: 600;
  }

  /* ================= ACTIVITY ================= */

  .activity-item {
    display: flex;
    justify-content: space-between;
    align-items: start;
    padding: 14px 18px;
  }

  .activity-time {
    background: #f1f3f5;
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 11px;
  }

  /* ================= STATUS ================= */

  .status-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 14px;
  }

  /* ================= PROGRESS ================= */

  .modern-progress {
    height: 8px;
    border-radius: 8px;
    background: #e9ecef;
  }

  .modern-progress .progress-bar {
    border-radius: 8px;
  }

  /* ================= MOBILE FIX ================= */

  @media (max-width: 768px) {

    .dashboard-container {
      padding-left: 6px !important;
      padding-right: 6px !important;
    }

    .dashboard-title {
      font-size: 18px;
    }

    .kpi-value {
      font-size: 20px;
    }

    .activity-item {
      flex-direction: column;
      gap: 6px;
    }

    .activity-time {
      align-self: flex-start;
    }

  }
</style>

<?= $this->endSection() ?>