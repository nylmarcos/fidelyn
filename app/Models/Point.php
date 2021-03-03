<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'data', 'validity',
        'customer_id', 'company_id', 'user_id'
    ];

    protected $dates = [
        'validity',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company');
    }
}
