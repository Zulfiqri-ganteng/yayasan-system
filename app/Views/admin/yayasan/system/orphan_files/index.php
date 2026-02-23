<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid orphan-wrapper px-lg-4 px-2">

    <!-- ================= PAGE HEADER ================= -->
    <div class="orphan-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1">Orphan File Cleaner</h4>
            <div class="text-muted small">
                Analisis & pembersihan file tidak terpakai di <code>/uploads</code>
            </div>
        </div>

        <div class="badge bg-light border text-dark px-3 py-2">
            System Tool
        </div>
    </div>

    <!-- ================= SUMMARY CARDS ================= -->
    <div class="row g-3 mt-2 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-label">Orphan Files</div>
                <div class="stat-value text-danger" id="statCount">0</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-label">Total Size</div>
                <div class="stat-value" id="statSize">0 MB</div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="stat-card">
                <div class="stat-label">Scanner Status</div>
                <div class="stat-status" id="scanStatus">
                    Idle – siap melakukan scanning
                </div>
            </div>
        </div>
    </div>

    <!-- ================= ACTION PANEL ================= -->
    <div class="card action-card mb-4">
        <div class="card-body d-flex flex-wrap gap-2 align-items-center">

            <button id="btnPreview" class="btn btn-primary px-4">
                🔍 Start Scan
            </button>

            <button id="btnDelete" class="btn btn-danger px-4" disabled>
                🗑️ Move To Trash
            </button>

            <div class="ms-auto small text-muted">
                Trash auto-clean: <b><?= env('ORPHAN_TRASH_DAYS', 30) ?> hari</b>
            </div>

        </div>
    </div>

    <!-- ================= PROGRESS BAR ================= -->
    <div class="progress-wrapper mb-4">
        <div class="progress-bar-inner" id="scannerBar"></div>
    </div>

    <!-- ================= RESULT TABLE ================= -->
    <div class="card result-card" id="resultCard" style="display:none">
        <div class="card-header bg-white fw-semibold">
            Orphan File List
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Filename</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody id="fileTable"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .orphan-wrapper {
        padding-top: 1rem;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .05);
        border: 1px solid #f1f3f5;
    }

    .stat-label {
        font-size: 12px;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
    }

    .action-card,
    .result-card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .05);
    }

    .progress-wrapper {
        width: 100%;
        height: 6px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-inner {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #4f46e5, #22c55e);
        transition: width .4s ease;
    }
</style>

<script>
    const previewBtn = document.getElementById('btnPreview');
    const deleteBtn = document.getElementById('btnDelete');
    const scannerBar = document.getElementById('scannerBar');
    const scanStatus = document.getElementById('scanStatus');
    const fileTable = document.getElementById('fileTable');
    const resultCard = document.getElementById('resultCard');
    const statCount = document.getElementById('statCount');
    const statSize = document.getElementById('statSize');

    function animateBar(percent) {
        scannerBar.style.width = percent + "%";
    }

    previewBtn.onclick = async function() {

        previewBtn.disabled = true;
        deleteBtn.disabled = true;
        resultCard.style.display = "none";
        fileTable.innerHTML = "";

        scanStatus.innerHTML = "Scanning database & uploads...";
        animateBar(30);

        try {

            const res = await fetch('<?= base_url('admin/yayasan/system/orphan-files/preview') ?>');
            const data = await res.json();

            animateBar(80);

            statCount.innerText = data.orphan_count ?? 0;
            statSize.innerText = data.orphan_size ?? "0 MB";

            if (data.orphan_count > 0) {
                deleteBtn.disabled = false;
                scanStatus.innerHTML = "Orphan ditemukan – siap dipindahkan ke Trash";
            } else {
                scanStatus.innerHTML = "System clean – tidak ada orphan file";
            }

            if (Array.isArray(data.files)) {
                data.files.forEach((f, i) => {
                    fileTable.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${i+1}</td>
                        <td class="fw-semibold text-danger">${f.name}</td>
                        <td class="small text-muted">${f.path}</td>
                    </tr>
                `);
                });
            }

            resultCard.style.display = "block";
            animateBar(100);
            setTimeout(() => animateBar(0), 1200);

        } catch (e) {
            scanStatus.innerHTML = "Terjadi error saat scanning";
        }

        previewBtn.disabled = false;
    };

    deleteBtn.onclick = async function() {

        if (!confirm("File akan dipindahkan ke Trash.\n\nLanjutkan?")) return;

        deleteBtn.disabled = true;
        scanStatus.innerHTML = "Memindahkan file ke Trash...";
        animateBar(60);

        const res = await fetch('<?= base_url('admin/yayasan/system/orphan-files/delete') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await res.json();
        animateBar(100);

        if (data.error) {
            alert("ERROR:\n" + data.error);
            deleteBtn.disabled = false;
            return;
        }

        alert(
            `Berhasil dipindahkan ke Trash:\n${data.deleted_count} file\n\n` +
            `Space dibebaskan: ${data.freed_size}`
        );

        location.reload();
    };
</script>

<?= $this->endSection() ?>