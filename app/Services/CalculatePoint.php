<?php

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Point;
use App\Models\Customer;
use Auth;

class CalculatePoint extends Service
{
    protected $price;
    protected $company;

    public function __construct($price, $company)
    {
        $this->price = $price;
        $this->company = $company;
    }
    
    public function handle()
    {      
        $points = $this->calculatePoints();
        return $points < 50 ? $points : 50; 
    }

    public function formatPrice() 
    {
        $price  = preg_replace("/[^0-9,]/", "", $this->price);
        return explode(",", $price)[0];
    }

    public function calculatePoints()
    {
        return (int)($this->formatPrice() / $this->company->price);
    }
}
