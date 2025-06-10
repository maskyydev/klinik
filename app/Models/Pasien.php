<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nama', 'alamat', 'tanggal_daftar', 'jenkel', 'nomor_telepon', 'username', 'pilihan',
        'penyakit', 'obat', 'qty', 'harga', 'obat2', 'qty2', 'obat3', 'qty3',
        'total', 'total2', 'total3'
    ];

    public $timestamps = false; // Atur ke true jika menggunakan created_at dan updated_at


    // Method untuk mencari berdasarkan nama dengan dukungan pagination
    public function scopeSearchByName($query, $name)
    {
        return $query->where('nama', 'like', "%$name%");
    }

    // Method untuk mendapatkan data dengan pagination
    public function getAllData($limit, $offset)
    {
        return $this->skip($offset)->take($limit)->get();
    }

    // Method untuk mendapatkan total baris data untuk pagination
    public function getTotalRows($name = null)
    {
        if ($name) {
            return $this->where('nama', 'like', "%$name%")->count();
        }
        return $this->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
