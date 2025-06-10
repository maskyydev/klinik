<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Riwayat extends Model
{
    protected $table = 'riwayat';
    protected $primaryKey = 'riwayat_id';
    public $timestamps = true; // Jika kolom `created_at` dan `updated_at` digunakan

    protected $fillable = [
        'obat',
        'harga',
        'qty',
        'created_at',
        'updated_at',
    ];

    /**
     * Ambil semua data transaksi.
     */
    public static function getAllTransactions()
    {
        return self::all();
    }

    /**
     * Simpan data transaksi terjual.
     */
    public static function insertTerjual(array $data)
    {
        return self::create($data);
    }

    /**
     * Kurangi stok berdasarkan ID obat.
     */
    public static function kurangiStok($obatId, $stokBaru)
    {
        $riwayat = self::find($obatId);

        if ($riwayat) {
            $newStok = max(0, $riwayat->stok - $stokBaru);
            $riwayat->stok = $newStok;
            $riwayat->save();
        }
    }

    /**
     * Cari transaksi berdasarkan nama obat.
     */
    public static function searchTransactions($keyword)
    {
        return self::where('nama_obat', 'like', '%' . $keyword . '%')->get();
    }
}
