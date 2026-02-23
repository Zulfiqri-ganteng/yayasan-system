<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .kop-container {
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-table {
            width: 100%;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .logo {
            width: 90px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
        }

        .line-1 {
            border-top: 3px solid #000;
            margin-top: 8px;
        }

        .line-2 {
            border-top: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 15px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .tanggal-cetak {
            text-align: right;
            font-size: 11px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            background: #f2f2f2;
            padding: 6px;
            text-align: center;
        }

        td {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            border: none;
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- ================= KOP SURAT ================= -->
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td width="15%">
                    <?php if (!empty($logoPath)) : ?>
                        <img src="<?= $logoPath ?>" class="logo">
                    <?php endif; ?>
                </td>
                <td width="85%" class="kop-text">
                    <h2><?= esc($sekolah['nama_sekolah'] ?? '-') ?></h2>
                    <p><?= esc($sekolah['alamat'] ?? '-') ?></p>
                    <p>
                        Telp: <?= esc($sekolah['no_telp'] ?? '-') ?> |
                        Email: <?= esc($sekolah['email'] ?? '-') ?>
                    </p>
                </td>
            </tr>
        </table>

        <div class="line-1"></div>
        <div class="line-2"></div>
    </div>

    <!-- ================= JUDUL ================= -->
    <div class="judul">
        LAPORAN PENDAFTAR PPDB (DITERIMA)
    </div>

    <div class="tanggal-cetak">
        Dicetak pada: <?= date('d F Y H:i') ?>
    </div>

    <!-- ================= TABEL ================= -->
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="25%">Nama Lengkap</th>
                <th width="15%">NISN</th>
                <th width="30%">Asal Sekolah</th>
                <th width="15%">No HP</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendaftar as $i => $row): ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td><?= esc($row['nama_lengkap']) ?></td>
                    <td class="text-center"><?= esc($row['nisn']) ?></td>
                    <td><?= esc($row['asal_sekolah']) ?></td>
                    <td><?= esc($row['no_hp']) ?></td>
                    <td class="text-center">Diterima</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ================= TANDA TANGAN ================= -->
    <table class="ttd">
        <tr>
            <td>
                <?= esc($sekolah['kabupaten'] ?? '') ?>, <?= date('d F Y') ?><br>
                Kepala Sekolah<br><br><br><br>
                <b><?= esc($sekolah['kepala_sekolah'] ?? '-') ?></b><br>
                NIP: <?= esc($sekolah['nip_kepala'] ?? '-') ?>
            </td>
        </tr>
    </table>

</body>

</html>