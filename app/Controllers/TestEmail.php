<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        $email = \Config\Services::email();

        $email->setTo('EMAIL_PRIBADI_KAMU@gmail.com');
        $email->setSubject('Test SMTP Yayasan Galajuara');
        $email->setMessage('
            <h2>SMTP Berhasil 🔥</h2>
            <p>Email ini dikirim dari sistem Yayasan Galajuara.</p>
        ');

        if ($email->send()) {
            return "Email berhasil dikirim!";
        } else {
            return $email->printDebugger(['headers']);
        }
    }
}
