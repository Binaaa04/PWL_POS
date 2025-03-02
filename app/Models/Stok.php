<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';
    public $timestamps = true;

    protected $fillable = [
        'stok_tanggal',
        'stok_jumlah',
        'barang_id',
        'user_id'
    ];

    public function barang()
    {
        return $this->belongsTo(Barangm::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(Userm::class, 'user_id');
    }
}
