<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ContentSecurityPolicy extends BaseConfig
{
    /*
    |--------------------------------------------------------------------------
    | BASIC SETTINGS
    |--------------------------------------------------------------------------
    */

    // Untuk testing pertama kali → ubah ke true dulu agar tidak merusak website
    public bool $reportOnly = true;

    // Jika mau kirim report pelanggaran CSP ke endpoint
    public ?string $reportURI = null;

    // Paksa semua HTTP jadi HTTPS
    public bool $upgradeInsecureRequests = true;

    /*
    |--------------------------------------------------------------------------
    | DEFAULT
    |--------------------------------------------------------------------------
    */

    public $defaultSrc = ["'self'"];

    /*
    |--------------------------------------------------------------------------
    | SCRIPT
    |--------------------------------------------------------------------------
    */

    public $scriptSrc = [
        "'self'",
        "'unsafe-inline'", // masih diperlukan untuk beberapa theme
        "'unsafe-eval'",   // chart / library tertentu

        // CDN
        "https://code.jquery.com",
        "https://cdn.jsdelivr.net",
        "https://cdnjs.cloudflare.com",
        "https://unpkg.com",

        // Google
        "https://www.google.com",
        "https://www.gstatic.com",
        "https://maps.googleapis.com",
        "https://maps.gstatic.com",
    ];

    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */

    public $styleSrc = [
        "'self'",
        "'unsafe-inline'",

        "https://fonts.googleapis.com",
        "https://cdn.jsdelivr.net",
        "https://cdnjs.cloudflare.com",
        "https://unpkg.com",
    ];

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    public $imageSrc = [
        "'self'",
        "data:",
        "blob:",
        "https:",
    ];

    /*
    |--------------------------------------------------------------------------
    | FONT
    |--------------------------------------------------------------------------
    */

    public $fontSrc = [
        "'self'",
        "https://fonts.gstatic.com",
        "https://cdnjs.cloudflare.com",
        "data:",
    ];

    /*
    |--------------------------------------------------------------------------
    | CONNECT (AJAX / API / Websocket)
    |--------------------------------------------------------------------------
    */

    public $connectSrc = [
        "'self'",
        "https:",
        "wss:", // untuk websocket future absensi realtime
    ];

    /*
    |--------------------------------------------------------------------------
    | MEDIA (Camera / Microphone / Barcode Scanner)
    |--------------------------------------------------------------------------
    */

    public $mediaSrc = [
        "'self'",
        "blob:",
        "data:",
    ];

    /*
    |--------------------------------------------------------------------------
    | OBJECT (Disable Flash / Legacy Plugin)
    |--------------------------------------------------------------------------
    */

    public $objectSrc = ["'none'"];

    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    public $formAction = ["'self'"];

    /*
    |--------------------------------------------------------------------------
    | FRAME (Iframe YouTube / Google Maps)
    |--------------------------------------------------------------------------
    */

    public $frameSrc = [
        "'self'",
        "https://www.youtube.com",
        "https://www.google.com",
        "https://maps.google.com",
    ];

    public $frameAncestors = ["'self'"];

    /*
    |--------------------------------------------------------------------------
    | BASE URI
    |--------------------------------------------------------------------------
    */

    public $baseURI = ["'self'"];

    /*
    |--------------------------------------------------------------------------
    | CHILD
    |--------------------------------------------------------------------------
    */

    public $childSrc = ["'self'"];

    /*
    |--------------------------------------------------------------------------
    | NONCE (Advanced CSP – nanti bisa diaktifkan)
    |--------------------------------------------------------------------------
    */

    public string $styleNonceTag  = '{csp-style-nonce}';
    public string $scriptNonceTag = '{csp-script-nonce}';
    public bool $autoNonce = false;
}
