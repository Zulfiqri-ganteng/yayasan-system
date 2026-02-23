<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- ================= HEADER ================= -->
  <!-- <div class="mb-4">
    <h4 class="fw-bold d-flex align-items-center">
      <i class="typcn typcn-lock-closed-outline me-2 text-primary"></i>
      Pengaturan Keamanan
    </h4>
    <p class="text-muted mb-0">
      Kelola keamanan akun Superadmin Yayasan Galajuara
    </p>
  </div> -->

  <div class="row g-4">

    <!-- ================= FORM ================= -->
    <div class="col-xl-8 col-lg-7">

      <div class="card shadow-sm border-0 h-100">

        <div class="card-header bg-primary text-white py-3">
          <h5 class="mb-0 d-flex align-items-center">
            <i class="typcn typcn-key-outline me-2 fs-5"></i>
            Ganti Password Superadmin
          </h5>
          <small class="opacity-75">
            Demi keamanan sistem, gunakan password yang kuat
          </small>
        </div>

        <div class="card-body p-4">

          <div id="alertBox"></div>

          <form id="passwordForm">
            <?= csrf_field() ?>

            <!-- PASSWORD LAMA -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Password Lama</label>
              <div class="input-group">
                <input type="password" name="password_lama" class="form-control" required>
                <span class="input-group-text toggle-eye">
                  <i class="typcn typcn-eye-outline"></i>
                </span>
              </div>
            </div>

            <!-- PASSWORD BARU -->
            <div class="mb-2">
              <label class="form-label fw-semibold">Password Baru</label>
              <div class="input-group">
                <input type="password" id="password_baru" name="password_baru" class="form-control" required>
                <span class="input-group-text toggle-eye">
                  <i class="typcn typcn-eye-outline"></i>
                </span>
              </div>
            </div>

            <!-- STRENGTH -->
            <div class="mb-4">
              <div class="progress" style="height:6px">
                <div id="strengthBar" class="progress-bar"></div>
              </div>
              <small id="strengthText" class="text-muted"></small>
            </div>

            <!-- KONFIRMASI -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
              <div class="input-group">
                <input type="password" name="password_konfirmasi" class="form-control" required>
                <span class="input-group-text toggle-eye">
                  <i class="typcn typcn-eye-outline"></i>
                </span>
              </div>
            </div>

            <button class="btn btn-primary w-100 py-2 fw-semibold" id="submitBtn">
              <i class="typcn typcn-lock-open-outline me-1"></i>
              Ganti Password
            </button>

          </form>

        </div>
      </div>

    </div>

    <!-- ================= INFO ================= -->
    <div class="col-xl-4 col-lg-5">

      <div class="card border-0 shadow-sm h-100">
        <div class="card-body p-4">

          <h6 class="fw-bold mb-3">
            <i class="typcn typcn-shield-outline me-1 text-primary"></i>
            Informasi Keamanan
          </h6>

          <ul class="list-unstyled small text-muted mb-4">
            <li class="mb-2">🔒 Password minimal 8 karakter</li>
            <li class="mb-2">🔠 Kombinasi huruf besar & kecil</li>
            <li class="mb-2">🔢 Angka & simbol disarankan</li>
            <li class="mb-2">🚪 Logout otomatis semua perangkat</li>
          </ul>

          <div class="alert alert-warning mb-0">
            <strong>Perhatian</strong><br>
            Setelah password diganti, Anda akan otomatis logout
            dan harus login ulang.
          </div>

        </div>
      </div>

    </div>

  </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
  document.querySelectorAll('.toggle-eye').forEach(btn => {
    btn.onclick = () => {
      const input = btn.previousElementSibling;
      input.type = input.type === 'password' ? 'text' : 'password';
      btn.innerHTML = input.type === 'password' ?
        '<i class="typcn typcn-eye-outline"></i>' :
        '<i class="typcn typcn-eye"></i>';
    };
  });

  const passwordInput = document.getElementById('password_baru');
  const bar = document.getElementById('strengthBar');
  const text = document.getElementById('strengthText');

  passwordInput.addEventListener('input', () => {
    const v = passwordInput.value;
    let s = 0;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/[0-9]/.test(v)) s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;

    const l = [
      ['25%', 'bg-danger', 'Lemah'],
      ['50%', 'bg-warning', 'Cukup'],
      ['75%', 'bg-info', 'Kuat'],
      ['100%', 'bg-success', 'Sangat Kuat']
    ];

    if (s) {
      bar.style.width = l[s - 1][0];
      bar.className = 'progress-bar ' + l[s - 1][1];
      text.innerText = l[s - 1][2];
    } else {
      bar.style.width = '0%';
      text.innerText = '';
    }
  });

  document.getElementById('passwordForm').addEventListener('submit', e => {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '⏳ Memproses...';

    fetch('<?= base_url('admin/pengaturan/ganti-password') ?>', {
        method: 'POST',
        body: new FormData(e.target),
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(r => r.json())
      .then(res => {
        document.getElementById('alertBox').innerHTML =
          `<div class="alert alert-${res.status}">${res.message}</div>`;
        if (res.status === 'success') {
          setTimeout(() => location.href = '<?= base_url('logout') ?>', 1500);
        }
        btn.disabled = false;
        btn.innerHTML = 'Ganti Password';
      });
  });
</script>

<?= $this->endSection() ?>