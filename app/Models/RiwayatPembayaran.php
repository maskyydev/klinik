<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    protected $table = 'riwayat_pembayaran';
    protected $primaryKey = 'id';

    // Aktifkan timestamps agar Laravel mengatur created_at dan updated_at
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'penyakit',
        'obat',               // string: daftar obat dipisah koma
        'qty',                // string: daftar qty dipisah koma
        'harga',              // string: daftar harga dipisah koma
        'total_harga',        // total keseluruhan
        'biaya_konsultasi',   // biaya tambahan
        'status',             // ENUM: 'lunas' atau 'belum lunas'
    ];

    /**
     * Pencarian dengan pagination
     */
    public static function searchWithPagination($name = null, $perPage = 10)
    {
        $query = self::query();

        if ($name) {
            $query->where('nama', 'like', '%' . $name . '%');
        }

        return $query->paginate($perPage);
    }

    /**
     * Menghitung total baris (digunakan jika tidak menggunakan paginate)
     */
    public static function getTotalRows($name = null)
    {
        $query = self::query();

        if ($name) {
            $query->where('nama', 'like', '%' . $name . '%');
        }

        return $query->count();
    }
}
