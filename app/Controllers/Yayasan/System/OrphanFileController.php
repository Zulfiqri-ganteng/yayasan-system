<?php

namespace App\Controllers\Yayasan\System;

use App\Controllers\BaseController;
use Config\Database;

class OrphanFileController extends BaseController
{
    protected string $uploadPath;
    protected string $trashPath;
    protected array $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];

    public function __construct()
    {
        $this->uploadPath = FCPATH . 'uploads/';
        $this->trashPath  = FCPATH . 'uploads/.trash/';

        if (!is_dir($this->trashPath)) {
            @mkdir($this->trashPath, 0777, true);
        }

        // AUTO CLEAN TRASH > 30 DAYS
        $this->cleanupOldTrash();
    }

    public function index()
    {
        return view('admin/yayasan/system/orphan_files/index');
    }

    /* ================= PREVIEW ================= */

    public function preview()
    {
        $dbFiles   = $this->getAllDatabaseFiles();
        $diskFiles = $this->getDiskFiles();

        $orphan = [];
        $size   = 0;

        foreach ($diskFiles as $file) {

            if (!$this->isReferenced($file['name'], $dbFiles)) {

                $orphan[] = $file;

                if (is_file($file['full'])) {
                    $fs = filesize($file['full']);
                    if ($fs !== false) {
                        $size += $fs;
                    }
                }
            }
        }

        return $this->response->setJSON([
            'orphan_count' => count($orphan),
            'orphan_size'  => $this->formatSize($size),
            'files'        => $orphan
        ]);
    }

    /* ================= DELETE (SAFE MODE) ================= */

    public function delete()
    {
        $dbFiles   = $this->getAllDatabaseFiles();
        $diskFiles = $this->getDiskFiles();

        $deleted = [];
        $size    = 0;
        $errors  = [];

        foreach ($diskFiles as $file) {

            if (!$this->isReferenced($file['name'], $dbFiles)) {

                if (!is_file($file['full'])) {
                    continue;
                }

                $fs = filesize($file['full']);
                if ($fs !== false) {
                    $size += $fs;
                }

                // ===== TARGET PATH =====
                $trashTarget = $this->trashPath . uniqid() . '_' . $file['name'];

                // ===== MOVE FILE =====
                if (!rename($file['full'], $trashTarget)) {

                    // fallback copy + unlink
                    if (copy($file['full'], $trashTarget)) {
                        unlink($file['full']);
                    } else {
                        $errors[] = $file['full'];
                        continue;
                    }
                }

                $deleted[] = $file['path'];
            }
        }

        if (!empty($errors)) {
            return $this->response->setJSON([
                'error' => 'Beberapa file gagal dipindahkan.',
                'details' => $errors
            ]);
        }

        return $this->response->setJSON([
            'deleted_count' => count($deleted),
            'freed_size'    => $this->formatSize($size),
            'files'         => $deleted
        ]);
    }



    /* ================= CORE ================= */

    protected function isReferenced(string $filename, array $dbFiles): bool
    {
        return in_array($filename, $dbFiles, true);
    }

    protected function getAllDatabaseFiles(): array
    {
        $db = Database::connect();

        $map = [

            // ===== YAYASAN =====
            'profil_yayasan'      => ['logo'],
            'tentang_yayasan'     => ['banner_image', 'foto_direktur'],
            'galeri_yayasan'      => ['foto'],
            'berita_yayasan'      => ['thumbnail'],

            // ===== CMS GLOBAL =====
            'cms_home'            => ['hero_image1', 'hero_image2', 'hero_image3', 'hero_image4', 'hero_image5', 'hero_image6'],
            'cms_home_sekolah'    => ['hero_image_1', 'hero_image_2', 'hero_image_3'],
            'cms_berita'          => ['featured_image'],
            'cms_galeri'          => ['gambar'],
            'cms_staff'           => ['foto'],
            'cms_pengumuman'      => ['file'],
            'cms_tentang_sekolah' => ['banner_image'],
            'cms_akademik'        => ['foto_sekolah', 'foto_kepsek'],
            'cms_fasilitas'       => ['gambar'],
            'cms_ekskul'          => ['gambar'],
            'cms_jurusan'         => ['foto_cover'], // IMPORTANT FIX
            'ppdb'                => ['banner'],
            'profil_sekolah'      => ['logo'],
        ];

        $files = [];

        foreach ($map as $table => $columns) {

            foreach ($columns as $col) {

                if (!$db->fieldExists($col, $table)) continue;

                $rows = $db->table($table)
                    ->select($col)
                    ->where("$col IS NOT NULL", null, false)
                    ->where("$col !=", '')
                    ->get()
                    ->getResultArray();

                foreach ($rows as $row) {

                    $value = trim($row[$col] ?? '');
                    if ($value !== '') {
                        $files[] = basename($value);
                    }
                }
            }
        }

        /* ===== PARSE HTML LONGTEXT CONTENT ===== */

        $htmlSources = [
            ['table' => 'cms_berita', 'column' => 'konten'],
            ['table' => 'berita_yayasan', 'column' => 'konten'],
            ['table' => 'tentang_yayasan', 'column' => 'konten'],
        ];

        foreach ($htmlSources as $source) {

            if (!$db->fieldExists($source['column'], $source['table'])) continue;

            $rows = $db->table($source['table'])
                ->select($source['column'])
                ->where("{$source['column']} IS NOT NULL", null, false)
                ->get()
                ->getResultArray();

            foreach ($rows as $row) {

                preg_match_all(
                    '/uploads\/([^"\']+\.(jpg|jpeg|png|webp|pdf))/i',
                    $row[$source['column']] ?? '',
                    $matches
                );

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $files[] = basename($match);
                    }
                }
            }
        }

        return array_unique($files);
    }

    protected function getDiskFiles(): array
    {
        $result = [];

        if (!is_dir($this->uploadPath)) return [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->uploadPath,
                \FilesystemIterator::SKIP_DOTS
            )
        );

        foreach ($iterator as $file) {

            if (!$file->isFile()) continue;

            $ext = strtolower($file->getExtension());
            if (!in_array($ext, $this->allowedExt, true)) continue;

            // ignore trash folder
            if (strpos($file->getPathname(), '.trash') !== false) continue;

            $result[] = [
                'name' => $file->getFilename(),
                'full' => $file->getPathname(),
                'path' => str_replace(FCPATH, '', $file->getPathname()),
            ];
        }

        return $result;
    }

    protected function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 3) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
    protected function cleanupOldTrash(): void
    {
        if (!is_dir($this->trashPath)) return;

        $days = (int) env('ORPHAN_TRASH_DAYS', 30);
        $limit = $days * 24 * 60 * 60;

        $now = time();

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->trashPath,
                \FilesystemIterator::SKIP_DOTS
            )
        );

        foreach ($iterator as $file) {

            if (!$file->isFile()) continue;

            if (($now - $file->getMTime()) > $limit) {
                @unlink($file->getPathname());
            }
        }
    }
}
