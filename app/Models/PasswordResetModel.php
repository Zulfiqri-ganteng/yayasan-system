<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'token_hash',
        'expires_at',
        'used'
    ];

    protected $useTimestamps = false;
}
