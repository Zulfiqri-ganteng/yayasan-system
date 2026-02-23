
<?php if ($profil): ?>
    <pre><?= print_r($profil, true) ?></pre>
<?php else: ?>
    <p>Profil sekolah belum diisi.</p>
<?php endif; ?>
<form action="<?= base_url('sekolah/profil/simpan') ?>" method="post">
    <div>
        <label for="nama_sekolah">Nama Sekolah:</label>
        <input type="text" id="nama_sekolah" name="nama_sekolah" value="<?= $profil['nama_sekolah'] ?? '' ?>">
    </div>
    <div>
        <label for="npsn">NPSN:</label>
        <input type="text" id="npsn" name="npsn" value="<?= $profil['npsn'] ?? '' ?>">
    </div>
    <div>
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?= $profil['alamat'] ?? '' ?>">
    </div>
    <div>
        <label for="kepala_sekolah">Kepala Sekolah:</label>
        <input type="text" id="kepala_sekolah" name="kepala_sekolah" value="<?= $profil['kepala_sekolah'] ?? '' ?>">
    </div>
    <button type="submit">Simpan Profil</button>