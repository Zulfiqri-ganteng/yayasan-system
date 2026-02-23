<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
    protected $table = 'login_attempts';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'ip_address',
        'attempts',
        'last_attempt',
        'locked_until'
    ];

    protected $useTimestamps = false;
}
