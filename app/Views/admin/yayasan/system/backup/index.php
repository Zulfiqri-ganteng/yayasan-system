<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<?php
function backupSize($file)
{
    $path = WRITEPATH . 'backups/' . $file;
    if (!is_file($path)) return '-';
    $size = filesize($path);
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    while ($size >= 1024 && $i < 3) {
        $size /= 1024;
        $i++;
    }
    return round($size, 2) . ' ' . $units[$i];
}
?>

<style>
    .page-wrap {
        max-width: 1100px;
    }

    .system-header h3 {
        font-weight: 700;
        margin-bottom: 4px;
    }

    .system-header p {
        color: #6b7280;
        font-size: 14px;
    }

    .card-pro {
        border: none;
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .05);
    }

    .card-pro+.card-pro {
        margin-top: 28px;
    }

    .hero-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .hero-box h5 {
        font-weight: 700;
    }

    .progress {
        height: 24px;
        border-radius: 20px;
        background: #e5e7eb;
    }

    .progress-bar {
        font-weight: 600;
        transition: width .4s ease;
    }

    .status-text {
        font-size: 13px;
        color: #6b7280;
        margin-top: 6px;
    }

    .backup-item {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .backup-item:last-child {
        border-bottom: none;
    }

    .backup-name {
        font-weight: 600;
    }

    .backup-meta {
        font-size: 12px;
        color: #6b7280;
    }

    .backup-actions {
        display: flex;
        gap: 8px;
    }

    .toast-box {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #111827;
        color: #fff;
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 14px;
        display: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
    }

    @media(max-width:768px) {
        .hero-box {
            flex-direction: column;
            align-items: stretch;
        }

        .backup-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .backup-actions {
            width: 100%;
            flex-direction: column;
        }

        .backup-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="page-wrap">

    <!-- HEADER -->
    <div class="system-header mb-4">
        <h3>💾 Backup & Restore System</h3>
        <p>
            Sistem pengamanan database & folder uploads.
            Hanya Superadmin yang dapat melakukan restore.
        </p>
    </div>

    <!-- BACKUP CARD -->
    <div class="card card-pro">
        <div class="card-body">

            <div class="hero-box">
                <div>
                    <h5>Backup Sistem</h5>
                    <div class="text-muted small">
                        Database + uploads dikemas dalam 1 file ZIP.
                    </div>
                </div>

                <button id="btnBackup" class="btn btn-primary btn-lg px-4">
                    🚀 Jalankan Backup
                </button>
            </div>

            <div class="mt-4 d-none" id="progressWrap">
                <div class="progress">
                    <div class="progress-bar bg-success"
                        id="progressBar"
                        style="width:0%">0%</div>
                </div>
                <div class="status-text" id="progressText"></div>
            </div>

        </div>
    </div>

    <!-- HISTORY CARD -->
    <div class="card card-pro">
        <div class="card-body p-0">

            <div class="px-4 py-3 border-bottom fw-semibold">
                📦 Riwayat Backup
            </div>

            <?php if (empty($backups)): ?>
                <div class="p-4 text-center text-muted">
                    Belum ada backup tersedia
                </div>
            <?php else: ?>
                <?php foreach ($backups as $b): ?>
                    <div class="backup-item">
                        <div>
                            <div class="backup-name"><?= esc($b) ?></div>
                            <div class="backup-meta">
                                Size: <?= backupSize($b) ?>
                                • <?= date('d M Y H:i', filemtime(WRITEPATH . 'backups/' . $b)) ?>
                            </div>
                        </div>

                        <div class="backup-actions">

                            <a href="<?= base_url('admin/yayasan/system/backup/download/' . $b) ?>"
                                class="btn btn-success">
                                ⬇ Download
                            </a>

                            <?php if (session('role') === 'superadmin'): ?>
                                <form action="<?= base_url('admin/yayasan/system/backup/restore') ?>"
                                    method="post">
                                    <input type="hidden" name="file" value="<?= esc($b) ?>">
                                    <button class="btn btn-warning"
                                        onclick="return confirm('Restore backup ini? Semua data akan ditimpa.')">
                                        ♻ Restore
                                    </button>
                                </form>

                                <button class="btn btn-danger"
                                    onclick="deleteBackup('<?= esc($b) ?>')">
                                    🗑 Hapus
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

</div>

<div class="toast-box" id="toastBox"></div>

<script>
    const btn = document.getElementById('btnBackup');
    const bar = document.getElementById('progressBar');
    const wrap = document.getElementById('progressWrap');
    const text = document.getElementById('progressText');
    const toast = document.getElementById('toastBox');

    function showToast(msg) {
        toast.innerText = msg;
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 3500);
    }

    function setProgress(p, label) {
        bar.style.width = p + '%';
        bar.innerText = p + '%';
        text.innerText = label;
    }

    btn.onclick = () => {
        btn.disabled = true;
        btn.innerText = '⏳ Processing...';
        wrap.classList.remove('d-none');

        setProgress(15, 'Dump database...');
        setTimeout(() => setProgress(50, 'Mengarsipkan uploads...'), 800);

        fetch('<?= base_url('admin/yayasan/system/backup/run-ajax') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })

            .then(r => r.json())
            .then(r => {
                if (r.status === 'success') {
                    setProgress(100, 'Backup selesai');
                    showToast('Backup berhasil dibuat');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(r.message);
                    location.reload();
                }
            });
    };

    function deleteBackup(file) {
        if (!confirm('Hapus backup ini? File tidak bisa dikembalikan.')) return;

        fetch('<?= base_url('admin/yayasan/system/backup/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'file=' + encodeURIComponent(file)
            })
            .then(r => r.json())
            .then(r => {
                if (r.status === 'success') {
                    showToast('Backup berhasil dihapus');
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast('Gagal menghapus backup');
                }
            });
    }
</script>

<?= $this->endSection() ?>