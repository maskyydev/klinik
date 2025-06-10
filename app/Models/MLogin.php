<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MLogin extends Model
{
    protected $table = 'users';          // Nama tabel
    protected $primaryKey = 'id';        // Primary key
    public $timestamps = false;          // Nonaktifkan timestamps jika tidak pakai created_at/updated_at

    protected $fillable = [              // Field yang boleh diisi massal
        'nama',
        'username',
        'password',
        'type',
    ];

    /**
     * Validasi kredensial pengguna (tidak direkomendasikan pakai plaintext).
     * Gunakan hashing password di sistem nyata.
     */
    public static function validateUser($username, $password)
    {
        return self::where('username', $username)
                   ->where('password', $password)
                   ->first();
    }
}
