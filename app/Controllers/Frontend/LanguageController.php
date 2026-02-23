<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class LanguageController extends BaseController
{
    public function switch($locale)
    {
        $supported = ['id', 'en', 'zh'];

        if (in_array($locale, $supported)) {
            session()->set('site_lang', $locale);
        }

        $referer = service('request')->getServer('HTTP_REFERER');

        // Kalau tidak ada referer atau referer mengandung login,
        // redirect ke homepage saja
        if (!$referer || str_contains($referer, 'login')) {
            return redirect()->to(base_url());
        }

        return redirect()->to($referer);
    }
}
