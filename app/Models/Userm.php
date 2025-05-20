<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Userm extends Authenticatable implements JWTSubject
{
        public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $table = 'm_user'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'user_id'; // Primary key tabel
    protected $fillable = ['username', 'password', 'name', 'level_id','image','created_at', 'updated_at'];
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

        public function getRole():string{
        return $this->level->level_kode;
    }
        public function getProfilePictureUrl()
    {
        return $this->image
            ? asset($this->image)
            : asset('adminlte/dist/img/user2-160x160.jpg');
    }
    protected function image():Attribute{
        return Attribute::make(
            get: fn($image)=>url('/storage/posts/'.$image),
        );
    }
}