<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;

    use SoftDeletes;

    // Kommt mit Model von Laravel als $dates = []
    protected $dates = ['deleted_at'];
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'release_date',
        'price',
        'rate',
        'author',
        'distributor',
        'path'
    ];

    public function user(){

        return $this->belongsTo('App\Models\User');
    }

    public function photos(){

        return $this->morphMany('App\Models\Photo', 'imageable');

    }

    public function tags(){

        return $this->morphToMany('App\Models\Tag', 'taggable');

    }


}
