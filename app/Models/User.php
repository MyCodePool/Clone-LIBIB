<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    # One to One Relationships
    public function post(){

        return $this->hasOne('App\Models\Post');
    }

    # One to Many Relationships
    public function posts(){

        return $this->hasMany('App\Models\Post');
    }

    public function roles(){

        // Laravel Video 65
        // Normalerweise müssten wir nun folgende Struktur aufbauen, aber
        // weil wir nach den Richtlinien von Laravel entwickeln, können
        // wir wir unten zu sehen verkürzt programmieren (Laravel Task Video 65./ 2.30 Min )
        # To customize tables and columns follow the format below
        //return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_id', 'role_id');

        return $this->belongsToMany('App\Models\Role')->withPivot('created_at');
    }

    public function photos(){

        return $this->morphMany('App\Models\Photo', 'imageable');

    }
}
