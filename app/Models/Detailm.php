<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailm extends Model
{
    use HasFactory;
    protected $table = 't_penjualan_detail'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'detail_id'; // Primary key tabel
    public $timestamps = true; // Jika pakai created_at & updated_at

    protected $fillable = [
        'harga',
        'jumlah',
        'barang_id',
        'penjualan_id'
    ];

    // Relasi ke tabel lain
    public function barang()
    {
        return $this->belongsTo(Barangm::class, 'barang_id');
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualanm::class, 'penjualan_id');
    }
}
