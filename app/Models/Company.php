<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'phone', 'price', 
        'points', 'user_id', 'months_point_expiration',
        'information'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
