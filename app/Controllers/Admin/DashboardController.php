<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        // ======================
        // KPI DATA (REAL)
        // ======================

        $totalSekolah = $db->table('sekolah')
            ->where('jenjang !=', 'yayasan')
            ->countAllResults();

        $totalSekolahAktif = $db->table('sekolah')
            ->where('jenjang !=', 'yayasan')
            ->where('status', 1)
            ->countAllResults();

        $totalAdmin = $db->table('users')
            ->where('role', 'admin_sekolah')
            ->countAllResults();

        $totalBerita = $db->table('cms_berita')
            ->where('status', 'publish')
            ->countAllResults();

        $totalFitur = $db->table('fitur')->countAllResults();

        $ppdbAktif = $db->table('ppdb')
            ->where('status', 'buka')
            ->countAllResults();

        $staffAktif = $db->table('cms_staff')
            ->where('status', 'aktif')
            ->countAllResults();

        // ======================
        // AUDIT LOG REAL
        // ======================

        $auditLogs = $db->table('audit_log al')
            ->select('al.*, u.username')
            ->join('users u', 'u.id = al.user_id', 'left')
            ->orderBy('al.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResultArray();

        // ======================
        // STORAGE REAL
        // ======================

        $path = FCPATH;
        $totalSpace = @disk_total_space($path) ?: 0;
        $freeSpace  = @disk_free_space($path) ?: 0;
        $usedSpace  = $totalSpace - $freeSpace;

        $storagePercent = $totalSpace > 0
            ? round(($usedSpace / $totalSpace) * 100)
            : 0;

        return view('admin/dashboard', [

            'title' => 'Dashboard Superadmin',
            // memindahkan api key dari chart js ke sini agar lebih aman dan mudah diakses oleh view,
            'googleMapsKey' => env('google.maps.apiKey'),
            // end api key
            'totalSekolah' => $totalSekolah,
            'totalSekolahAktif' => $totalSekolahAktif,
            'totalAdmin' => $totalAdmin,
            'totalBerita' => $totalBerita,
            'totalFitur' => $totalFitur,
            'ppdbAktif' => $ppdbAktif,
            'staffAktif' => $staffAktif,

            'auditLogs' => $auditLogs,

            'storagePercent' => $storagePercent,
            'totalSpace' => $this->formatSize($totalSpace),
            'usedSpace' => $this->formatSize($usedSpace),
        ]);
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 4) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
