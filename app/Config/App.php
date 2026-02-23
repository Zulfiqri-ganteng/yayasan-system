<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = 'http://localhost:8080/';

    /**
     * Allowed Hostnames in the Site URL other than the hostname in the baseURL.
     * If you want to accept multiple Hostnames, set this.
     *
     * E.g.,
     * When your site URL ($baseURL) is 'http://example.com/', and your site
     * also accepts 'http://media.example.com/' and 'http://accounts.example.com/':
     *     ['media.example.com', 'accounts.example.com']
     *
     * @var list<string>
     */
    public array $allowedHostnames = [];


    public string $indexPage = '';


    public string $uriProtocol = 'REQUEST_URI';


    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    public string $defaultLocale = 'id';


    public bool $negotiateLocale = false;


    public array $supportedLocales = ['id', 'en', 'zh'];

    public string $appTimezone = 'UTC';

    public string $charset = 'UTF-8';


    // public bool $forceGlobalSecureRequests = false;
    public bool $forceGlobalSecureRequests = ENVIRONMENT === 'production';

    /**
     * --------------------------------------------------------------------------
     * Reverse Proxy IPs
     * --------------------------------------------------------------------------
     *
     * If your server is behind a reverse proxy, you must whitelist the proxy
     * IP addresses from which CodeIgniter should trust headers such as
     * X-Forwarded-For or Client-IP in order to properly identify
     * the visitor's IP address.
     *
     * You need to set a proxy IP address or IP address with subnets and
     * the HTTP header for the client IP address.
     *
     * Here are some examples:
     *     [
     *         '10.0.1.200'     => 'X-Forwarded-For',
     *         '192.168.5.0/24' => 'X-Real-IP',
     *     ]
     *
     * @var array<string, string>
     */
    public array $proxyIPs = [];


    public bool $CSPEnabled = true;
}
