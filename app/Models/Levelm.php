<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Levelm extends Model
{
    use HasFactory;
    protected $table = 'm_level'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'level_id'; // Primary key tabel
    public $timestamps = true; // Jika pakai created_at & updated_at

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];
}
