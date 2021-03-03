<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'phone'
    ];

    public function points()
    {
        return $this->hasOne('App\Models\Point');
    }

    public function extrato()
    {
        return $this->points();
    }
}
