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

}
