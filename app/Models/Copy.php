<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    protected $fillable = [
        'cookbook_i',
        'status',
        'condition',
    ];

    public function cookbook(){
        return $this->belongsTo(CookBook::class);
    }

    public function borrows(){
        return $this->hasMany(Borrow::class);
    }
}