<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualanm extends Model
{
    use HasFactory;
    
    protected $table = 't_penjualan'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'penjualan_id'; // Primary key tabel
    public $timestamps = true; 

    protected $fillable = [
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(Userm::class, 'user_id');
    }
}
