<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $table = 'hasil';

    protected $fillable = [
        'nama',
        'penyakit',
        'obat',              // string: daftar obat dipisah koma
        'qty',               // string: daftar qty dipisah koma
        'harga',             // string: daftar harga dipisah koma
        'total_harga',
        'biaya_konsultasi',
    ];

    // Jika ingin otomatis handle timestamps (created_at, updated_at)
    public $timestamps = true;
}
