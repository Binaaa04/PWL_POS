<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Userm extends Authenticatable
{
    use HasFactory;
    protected $table = 'm_user'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'user_id'; // Primary key tabel
    protected $fillable = ['username', 'password', 'name', 'level_id', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $casts = ['password'=>'hashed'];
    //public $timestamps = true; 
    public function level()
    {
        return $this->belongsTo(Levelm::class, 'level_id', 'level_id');
    }

    /**
     * Summary of getRoleName
     * @return string
     */
    public function getRoleName():string{
        return $this->level->level_nama;
    }
    /**
     * check if user have any role
     */
    public function hasRole($role):bool{
        return $this->level->level_kode == $role;
    }
}