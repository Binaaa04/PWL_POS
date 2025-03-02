<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'm_user'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'user_id'; // Primary key tabel
    public $timestamps = true; // Jika pakai created_at & updated_at

    protected $fillable = [
        'username',
        'name',
        'password',
        'level_id'
    ];
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id');
    }
}
