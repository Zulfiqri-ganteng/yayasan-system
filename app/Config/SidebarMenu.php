<?php

return [

    // =========================
    // UTAMA
    // =========================
    [
        'label' => 'Dashboard',
        'icon'  => 'typcn typcn-device-desktop',
        'url'   => 'sekolah/dashboard',
        'fitur' => 'dashboard',
    ],

    [
        'label' => 'Profil Sekolah',
        'icon'  => 'typcn typcn-home-outline',
        'url'   => 'sekolah/profil',
        'fitur' => 'profil_sekolah',
    ],

    // =========================
    // PPDB
    // =========================
    [
        'label' => 'Pengaturan PPDB',
        'icon'  => 'typcn typcn-cog-outline',
        'url'   => 'sekolah/ppdb-setting',
        'fitur' => 'ppdb',
    ],
    [
        'label' => 'Pendaftar PPDB',
        'icon'  => 'typcn typcn-user-add-outline',
        'url'   => 'sekolah/ppdb-pendaftar',
        'fitur' => 'ppdb',
    ],

    // =========================
    // AKADEMIK
    // =========================
    [
        'label' => 'Tahun Ajaran',
        'icon'  => 'typcn typcn-calendar-outline',
        'url'   => 'sekolah/tahun-ajaran',
        'fitur' => 'akademik',
    ],
    [
        'label' => 'Kelas & Rombel',
        'icon'  => 'typcn typcn-group-outline',
        'url'   => 'sekolah/kelas',
        'fitur' => 'akademik',
    ],
    [
        'label' => 'Jadwal Pelajaran',
        'icon'  => 'typcn typcn-time',
        'url'   => 'sekolah/jadwal',
        'fitur' => 'akademik',
    ],

    // =========================
    // ABSENSI
    // =========================
    [
        'label' => 'Absensi Siswa',
        'icon'  => 'typcn typcn-tick-outline',
        'url'   => 'sekolah/absensi',
        'fitur' => 'absensi',
    ],
    [
        'label' => 'Scan QR / Barcode',
        'icon'  => 'typcn typcn-camera-outline',
        'url'   => 'sekolah/absensi-qr',
        'fitur' => 'absensi_qr',
    ],

    // =========================
    // KEUANGAN
    // =========================
    [
        'label' => 'Tabungan',
        'icon'  => 'typcn typcn-wallet',
        'url'   => 'sekolah/tabungan',
        'fitur' => 'tabungan',
    ],
    [
        'label' => 'Pembayaran',
        'icon'  => 'typcn typcn-credit-card',
        'url'   => 'sekolah/pembayaran',
        'fitur' => 'pembayaran',
    ],

    // =========================
    // SMK ONLY
    // =========================
    [
        'label' => 'BKK',
        'icon'  => 'typcn typcn-briefcase',
        'url'   => 'sekolah/bkk',
        'fitur' => 'bkk',
    ],
    [
        'label' => 'PKL',
        'icon'  => 'typcn typcn-clipboard',
        'url'   => 'sekolah/pkl',
        'fitur' => 'pkl',
    ],
];
