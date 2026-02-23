<?php

namespace App\Controllers\Yayasan\System;

use App\Controllers\BaseController;
use Config\Database;
use ZipArchive;
use CodeIgniter\Exceptions\PageNotFoundException;

class BackupController extends BaseController
{
    protected string $backupPath;
    protected string $uploadPath;

    public function __construct()
    {
        $this->backupPath = WRITEPATH . 'backups/';
        $this->uploadPath = FCPATH . 'uploads/';

        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0775, true);
        }
    }

    /* =====================================================
     * INDEX
     * ===================================================== */
    public function index()
    {
        $files = array_values(array_filter(scandir($this->backupPath), function ($f) {
            return str_ends_with($f, '.zip');
        }));

        rsort($files);

        return view('admin/yayasan/system/backup/index', [
            'backups' => $files
        ]);
    }

    /* =====================================================
     * AJAX BACKUP
     * ===================================================== */
    public function runAjax()
    {
        if (!$this->request->isAJAX() || session('role') !== 'superadmin') {
            return $this->response->setStatusCode(403);
        }

        try {

            $timestamp = date('Y-m-d_H-i-s');
            $zipName   = "backup_{$timestamp}.zip";
            $zipFile   = $this->backupPath . $zipName;

            $zip = new ZipArchive();

            if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
                throw new \Exception('Gagal membuat file ZIP');
            }

            // 1️⃣ Dump database
            $sql = $this->dumpDatabase();
            $zip->addFromString('database.sql', $sql);

            // 2️⃣ Zip uploads
            $this->zipFolder($zip, $this->uploadPath, 'uploads');

            $zip->close();

            return $this->response->setJSON([
                'status' => 'success',
                'file'   => $zipName
            ]);
        } catch (\Throwable $e) {

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /* =====================================================
     * DELETE BACKUP
     * ===================================================== */
    public function delete()
    {
        if (!$this->request->isAJAX() || session('role') !== 'superadmin') {
            return $this->response->setStatusCode(403);
        }

        $file = basename($this->request->getPost('file'));

        if (!str_ends_with($file, '.zip')) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $path = $this->backupPath . $file;

        if (!is_file($path)) {
            return $this->response->setJSON(['status' => 'error']);
        }

        unlink($path);

        return $this->response->setJSON(['status' => 'success']);
    }

    /* =====================================================
     * RESTORE
     * ===================================================== */
    public function restore()
    {
        if (session('role') !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $file = basename($this->request->getPost('file'));
        $zipFile = $this->backupPath . $file;

        if (!is_file($zipFile)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan');
        }

        $zip = new ZipArchive();

        if ($zip->open($zipFile) !== true) {
            return redirect()->back()->with('error', 'Gagal membuka file backup');
        }

        $tmp = WRITEPATH . 'restore_tmp/';

        if (is_dir($tmp)) {
            $this->deleteDir($tmp);
        }

        mkdir($tmp, 0775, true);
        $zip->extractTo($tmp);
        $zip->close();

        $db = Database::connect();
        $db->transStart();

        try {

            // Restore DB
            $sqlFile = $tmp . 'database.sql';
            if (is_file($sqlFile)) {
                $sql = file_get_contents($sqlFile);
                $db->query($sql);
            }

            // Restore uploads
            if (is_dir($tmp . 'uploads')) {
                $this->copyDir($tmp . 'uploads', $this->uploadPath);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Restore database gagal');
            }
        } catch (\Throwable $e) {

            $db->transRollback();
            $this->deleteDir($tmp);

            return redirect()->back()->with('error', $e->getMessage());
        }

        $this->deleteDir($tmp);

        return redirect()->back()->with('success', 'Restore berhasil dilakukan');
    }

    /* =====================================================
     * DOWNLOAD
     * ===================================================== */
    public function download($file)
    {
        $file = basename($file);
        $path = $this->backupPath . $file;

        if (!is_file($path)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response->download($path, null);
    }

    /* =====================================================
     * UTILITIES
     * ===================================================== */

    protected function dumpDatabase(): string
    {
        $db = Database::connect();
        $tables = $db->listTables();
        $sql = "-- Database Backup\nSET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {

            $create = $db->query("SHOW CREATE TABLE `$table`")->getRowArray();

            $sql .= "DROP TABLE IF EXISTS `$table`;\n";
            $sql .= $create['Create Table'] . ";\n\n";

            $rows = $db->table($table)->get()->getResultArray();

            foreach ($rows as $row) {
                $values = array_map(fn($v) => $db->escape($v), array_values($row));
                $sql .= "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n";
            }

            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $sql;
    }

    protected function zipFolder(ZipArchive $zip, string $folder, string $root)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            if ($file->isFile()) {

                $local = $root . '/' . substr($file->getPathname(), strlen($folder));
                $local = str_replace('\\', '/', $local);

                $zip->addFile($file->getPathname(), $local);
            }
        }
    }

    protected function copyDir($src, $dst)
    {
        if (!is_dir($dst)) {
            mkdir($dst, 0775, true);
        }

        foreach (scandir($src) as $file) {

            if ($file === '.' || $file === '..') continue;

            $from = $src . '/' . $file;
            $to   = $dst . '/' . $file;

            if (is_dir($from)) {
                $this->copyDir($from, $to);
            } else {
                copy($from, $to);
            }
        }
    }

    protected function deleteDir($dir)
    {
        if (!is_dir($dir)) return;

        foreach (scandir($dir) as $file) {

            if ($file === '.' || $file === '..') continue;

            $path = $dir . '/' . $file;

            is_dir($path)
                ? $this->deleteDir($path)
                : unlink($path);
        }

        rmdir($dir);
    }
}
