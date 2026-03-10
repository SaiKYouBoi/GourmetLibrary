<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CookBook extends Model
{
    protected $fillable = [
        'title',
        'chef',
        'description',
        'category_id'
    ];

    protected $table = 'cookbooks';

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function copies(){
        return $this->hasMany(Copy::class);
    }
}
