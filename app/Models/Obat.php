<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';
    protected $primaryKey = 'id';
    public $timestamps = false; // jika tidak menggunakan kolom created_at dan updated_at

    protected $fillable = ['nama_obat', 'harga_jual', 'harga_beli', 'stok', 'untuk_penyakit'];

    // Method for getting all 'obat masuk' data
    public static function getAllMasuk()
    {
        return self::all();
    }

    // Method for searching by name with pagination support
    public static function searchByName($name, $limit = 10, $offset = 0)
    {
        return self::where('nama_obat', 'like', "%$name%")
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
    }

    // Method to get total rows for pagination
    public static function getTotalRows($name = null)
    {
        if ($name) {
            return self::where('nama_obat', 'like', "%$name%")->count();
        }
        return self::count();
    }

    // Method for searching 'obat masuk' with keyword
    public static function searchMasuk($keyword)
    {
        return self::where('nama_obat', 'like', "%$keyword%")->get();
    }
}
