<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'copy_id',
        'borrow_date',
        'return_date'
    ];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'datetime',
            'return_date' => 'datetime',
        ];
    }

    public function copy(){
        return $this->belongsTo(Copy::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}