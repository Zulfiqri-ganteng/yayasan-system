<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\SekolahFiturModel;
use App\Models\FiturModel;

class FiturSekolahController extends BaseController
{
    protected $sekolahModel;
    protected $sekolahFiturModel;
    protected $fiturModel;

    // Fitur inti yang tidak boleh dimatikan
    protected array $coreFitur = ['dashboard', 'profil_sekolah'];

    public function __construct()
    {
        $this->sekolahModel      = new SekolahModel();
        $this->sekolahFiturModel = new SekolahFiturModel();
        $this->fiturModel        = new FiturModel();
    }

    /**
     * ===============================
     * TAMPIL HALAMAN FITUR SEKOLAH
     * ===============================
     */
    public function index($sekolah_id)
    {
        $sekolah = $this->sekolahModel->find($sekolah_id);
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Sekolah tidak ditemukan');
        }

        /**
         * 1️⃣ Ambil SEMUA master fitur
         * table: fitur
         * kolom kode: kode
         */
        $fiturMaster = $this->fiturModel->findAll();

        /**
         * 2️⃣ Ambil fitur sekolah
         * table: sekolah_fitur
         * kolom kode: fitur_kode
         */
        $fiturSekolah = $this->sekolahFiturModel
            ->where('sekolah_id', $sekolah_id)
            ->findAll();

        /**
         * 3️⃣ Mapping fitur sekolah by kode
         */
        $mapSekolahFitur = [];
        foreach ($fiturSekolah as $sf) {
            $mapSekolahFitur[$sf['fitur_kode']] = $sf;
        }

        /**
         * 4️⃣ Merge → SEMUA FITUR HARUS TAMPIL
         */
        $fitur = [];
        foreach ($fiturMaster as $f) {

            // ⛔ INI YANG TADI SALAH
            // master pakai `kode`, bukan `fitur_kode`
            $kode = $f['kode'];

            $fitur[] = [
                'fitur_kode' => $kode,
                'aktif'      => $mapSekolahFitur[$kode]['aktif'] ?? 0,
                'locked'     => in_array($kode, $this->coreFitur, true),
            ];
        }

        return view('admin/sekolah_fitur/index', [
            'title'            => 'Fitur Sekolah',
            'sekolah'          => $sekolah,
            'fitur'            => $fitur,
            'fiturMaster'      => $fiturMaster,
            'mapSekolahFitur'  => $mapSekolahFitur,
        ]);
    }

    /**
     * ===============================
     * TOGGLE SATU FITUR (LEGACY)
     * ===============================
     */
    public function toggle()
    {
        $id = $this->request->getPost('id');

        $fitur = $this->sekolahFiturModel->find($id);
        if (!$fitur) {
            return redirect()->back()->with('error', 'Data fitur tidak ditemukan');
        }

        // ⛔ BLOK FITUR CORE
        if (in_array($fitur['fitur_kode'], $this->coreFitur, true)) {
            return redirect()->back()
                ->with('error', 'Fitur CORE tidak boleh diubah.');
        }

        $this->sekolahFiturModel->update($id, [
            'aktif' => $fitur['aktif'] ? 0 : 1
        ]);

        return redirect()->back()->with('success', 'Status fitur diperbarui');
    }

    /**
     * ===============================
     * BULK AKTIF / NONAKTIF FITUR
     * ===============================
     */
    public function bulk()
    {
        $sekolah_id = $this->request->getPost('sekolah_id');
        $fiturList  = (array) $this->request->getPost('fitur_kode');
        $aksi       = $this->request->getPost('aksi'); // on | off

        if (!$sekolah_id || empty($fiturList) || !in_array($aksi, ['on', 'off'], true)) {
            return redirect()->back()->with('error', 'Data bulk tidak valid');
        }

        $sekolah = $this->sekolahModel->find($sekolah_id);
        if (!$sekolah || !$sekolah['status']) {
            return redirect()->back()->with('error', 'Sekolah tidak aktif');
        }

        $aktifValue = $aksi === 'on' ? 1 : 0;

        foreach ($fiturList as $kode) {

            // ⛔ Skip fitur CORE
            if (in_array($kode, $this->coreFitur, true)) {
                continue;
            }

            $existing = $this->sekolahFiturModel
                ->where('sekolah_id', $sekolah_id)
                ->where('fitur_kode', $kode)
                ->first();

            if ($existing) {
                $this->sekolahFiturModel->update($existing['id'], [
                    'aktif' => $aktifValue
                ]);
            } else {
                $this->sekolahFiturModel->insert([
                    'sekolah_id' => $sekolah_id,
                    'fitur_kode' => $kode,
                    'aktif'      => $aktifValue
                ]);
            }
        }

        return redirect()->back()->with('success', 'Bulk fitur berhasil diperbarui');
    }

    /**
     * ===============================
     * TAMBAH FITUR KE SEKOLAH (BARU)
     * ===============================
     */
    public function add()
    {
        $sekolah_id = $this->request->getPost('sekolah_id');
        $fiturKode  = (array) $this->request->getPost('fitur_kode');

        if (!$sekolah_id || empty($fiturKode)) {
            return redirect()->back()->with('error', 'Pilih minimal satu fitur');
        }

        $sekolah = $this->sekolahModel->find($sekolah_id);
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Sekolah tidak valid');
        }

        foreach ($fiturKode as $kode) {

            // ⛔ Jangan dobel
            $exists = $this->sekolahFiturModel
                ->where('sekolah_id', $sekolah_id)
                ->where('fitur_kode', $kode)
                ->first();

            if ($exists) {
                continue;
            }

            $this->sekolahFiturModel->insert([
                'sekolah_id' => $sekolah_id,
                'fitur_kode' => $kode,
                'aktif'      => 0 // default OFF
            ]);
        }

        return redirect()->back()->with('success', 'Fitur berhasil ditambahkan');
    }
    public function addForm($sekolah_id)
    {
        $sekolah = $this->sekolahModel->find($sekolah_id);
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Sekolah tidak ditemukan');
        }

        // Semua fitur master
        $allFitur = $this->fiturModel->findAll();

        // Fitur yang sudah dimiliki sekolah
        $existing = $this->sekolahFiturModel
            ->where('sekolah_id', $sekolah_id)
            ->findColumn('fitur_kode');

        // Filter: hanya fitur yang BELUM dimiliki
        $fiturTersedia = array_filter($allFitur, function ($f) use ($existing) {
            return !in_array($f['kode'], $existing ?? []);
        });

        return view('admin/sekolah_fitur/add', [
            'title'  => 'Tambah Fitur Sekolah',
            'sekolah' => $sekolah,
            'fitur'  => $fiturTersedia,
        ]);
    }
    public function delete()
    {
        $sekolah_id = $this->request->getPost('sekolah_id');
        $kode       = $this->request->getPost('fitur_kode');

        if (!$sekolah_id || !$kode) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        // ⛔ BLOCK CORE
        if (in_array($kode, $this->coreFitur, true)) {
            return redirect()->back()
                ->with('error', 'Fitur CORE tidak boleh dihapus');
        }

        $existing = $this->sekolahFiturModel
            ->where('sekolah_id', $sekolah_id)
            ->where('fitur_kode', $kode)
            ->first();

        if (!$existing) {
            return redirect()->back()
                ->with('error', 'Fitur belum ditambahkan ke sekolah');
        }

        $this->sekolahFiturModel->delete($existing['id']);

        return redirect()->back()
            ->with('success', 'Fitur berhasil dihapus dari sekolah');
    }
}
