<!DOCTYPE html>
<html>

<head>
    <title>Print Data PPDB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .alamat {
            text-align: center;
            font-size: 11px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            background: #f2f2f2;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">

    <h2>
        DATA PENDAFTAR PPDB<br>
        <?= esc($sekolah['nama_sekolah'] ?? '-') ?>
    </h2>

    <div class="alamat">
        <?= esc($sekolah['alamat'] ?? '-') ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Asal Sekolah</th>
                <th>No HP</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendaftar as $i => $row): ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td><?= esc($row['nama_lengkap']) ?></td>
                    <td><?= esc($row['nisn']) ?></td>
                    <td><?= esc($row['asal_sekolah']) ?></td>
                    <td><?= esc($row['no_hp']) ?></td>
                    <td class="text-center"><?= ucfirst($row['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>