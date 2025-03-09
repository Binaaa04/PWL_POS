<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategorim extends Model
{
    use HasFactory;
    protected $table = 'm_kategori'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'kategori_id'; // Primary key tabel
    public $timestamps = true; // Jika pakai created_at & updated_at

    protected $fillable = [
        'kategori_kode',
        'kategori_nama',
    ];
    public function barang():HasMany{
        return $this->hasMany(Barangm::class, 'barang_id', 'barang_id');
    }
}
