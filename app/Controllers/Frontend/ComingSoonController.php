<?php

namespace App\Controllers\Frontend;

class ComingSoonController extends FrontendBaseController
{
    /**
     * Generic coming soon
     */
    private function show(string $fitur)
    {
        return view('frontend/coming_soon/index', [
            'title' => 'Segera Hadir - ' . strtoupper($fitur),
            'fitur' => strtoupper($fitur),
        ]);
    }

    public function pkl()
    {
        return $this->show('PKL');
    }

    public function bkk()
    {
        return $this->show('BKK');
    }

    public function ekskul()
    {
        return $this->show('Ekstrakurikuler');
    }
    public function kurikulum()
    {
        return $this->show('Kurikulum');
    }

    public function osis()
    {
        return $this->show('OSIS');
    }

    public function prestasi()
    {
        return $this->show('Prestasi Siswa');
    }
}
