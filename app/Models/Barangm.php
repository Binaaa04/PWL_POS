<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangm extends Model
{
    use HasFactory;
    protected $table = 'm_barang'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'barang_id'; // Primary key tabel
    public $timestamps = true; 

    protected $fillable = [
        'barang_kode',
        'nama_barang',
        'harga_beli',
        'harga_jual',
        'kategori_id'
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategorim::class, 'kategori_id');
    }
}
