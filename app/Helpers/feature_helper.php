<?php

use Config\Database;

if (!function_exists('school_has_feature')) {

    function school_has_feature(string $fitur_kode): bool
    {
        // ===============================
        // VALIDASI SESSION
        // ===============================
        if (!session()->get('isLoggedIn') || !session()->get('sekolah_id')) {
            return false;
        }

        // ===============================
        // CORE FEATURE (TIDAK BISA DIMATIKAN)
        // ===============================
        $coreFeatures = [
            'dashboard',
            'profil_sekolah',
        ];

        // ✅ CORE SELALU AKTIF
        if (in_array($fitur_kode, $coreFeatures, true)) {
            return true;
        }

        // ===============================
        // NON-CORE FEATURE (DB BASED)
        // ===============================
        $db        = Database::connect();
        $sekolahId = session()->get('sekolah_id');
        $jenjang   = session()->get('jenjang');

        /**
         * 1️⃣ Override oleh Superadmin (sekolah_fitur)
         *    - Jika ada record → ikuti nilai aktif
         */
        $override = $db->table('sekolah_fitur')
            ->where('sekolah_id', $sekolahId)
            ->where('fitur_kode', $fitur_kode)
            ->get()
            ->getRowArray();

        if ($override !== null) {
            return (bool) $override['aktif'];
        }

        /**
         * 2️⃣ Default dari fitur_jenjang
         *    - Aktif jika diset aktif untuk jenjang tsb
         */
        return $db->table('fitur_jenjang')
            ->where('jenjang', $jenjang)
            ->where('fitur_kode', $fitur_kode)
            ->where('aktif', 1)
            ->countAllResults() > 0;
    }
}
