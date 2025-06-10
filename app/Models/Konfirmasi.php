<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfirmasi extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi';

    protected $fillable = [
        'nama',
        'alamat',
        'tanggal_daftar',
        'jenkel',
        'nomor_telepon',
        'username',
        'pilihan'
    ];
}
