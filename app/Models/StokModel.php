<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;
    protected $table = 't_stok'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'stok_id'; // Primary key tabel
    public $timestamps = true; // Jika pakai created_at & updated_at

    protected $fillable = [
        'stok_tanggal',
        'stok_jumlah',
        'barang_id',
        'user_id'
    ];

    // Relasi ke tabel lain
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
