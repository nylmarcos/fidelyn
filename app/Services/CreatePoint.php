<?php

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Point;
use App\Models\Customer;
use Auth;
use App\Services\CalculatePoint;

class CreatePoint extends Service
{
    protected $request;
    protected $company;
    protected $user;

    public function __construct($request, $company, $user)
    {
        $this->request = $this->getRequestInstance($request);
        $this->company = $company;
        $this->user = $user;
    }
    
    public function handle()
    {      
        $points_number = (new CalculatePoint($this->request->input('price'), $this->company))->handle();
        if ($points_number == 0 ) {
            throw new \Exception("O valor da compra não dá direito a pontos");
        }

        $validity = $this->getValidity(); 
        $customer = $this->getCustomerByPhone($this->request->input('phone'));
       
        $points_data = [
            'data' => json_encode(['price' => $this->request->input('price')]),
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
            'customer_id' => $customer->id,
            'validity' => $validity,
        ];

        $points = array_fill(0, $points_number, $points_data);
        foreach ($points as $point) {
            Point::create($point);
        }

        return $points_number;
    }

    public function getValidity()
    {
        $date = new \DateTime();
        $date->modify("+{$this->company->months_point_expiration} month");
        return $date->format('Y-m-d');
    }

    public function getCustomerByPhone($phone)
    {
        $phone =  preg_replace("/[^0-9]/", "", $phone);

        return Customer::firstOrCreate(
            ['phone' =>  $phone ]
        );
    }
}
