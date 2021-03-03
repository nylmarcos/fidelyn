<?php

namespace App\Http\Controllers;

use App\Http\Requests\RescuePointRequest;
use App\Models\Point;
use App\Models\Customer;
use App\Models\Company;
use Auth;
use DB;
use Illuminate\Http\Request;

class PointCustomerController extends Controller
{
    public function __construct()
    {
        
    }

    public function extract(Request $request, $company_id = null)
    {
        $phone_format = $request->input('phone');
        $phone =  preg_replace("/[^0-9]/", "", $request->input('phone'));
        
        $extrato = [];
        if (!$phone) {
            return view('point.extract', compact('extrato', 'phone_format', 'company_id'));
        }
        $company = null;
        if ($company_id) {
            $company = Company::find($company_id);
        }

        $query = DB::table('companies')
            ->join('points', 'companies.id', '=', 'points.company_id')
            ->join('customers', 'points.customer_id', '=', 'customers.id')
            ->select('companies.*', 'customers.id as customer_id')
            ->where('customers.phone', $phone)
            ->groupBy('points.company_id', 'customers.id');

        if ($company_id) {
            $query->where('companies.id', $company_id);
        }

        $companies = $query->get();
        
        foreach ($companies as $company_point) {
            $date = new \DateTime();
            $date->modify("-{$company_point->months_point_expiration} month");
            
            $points = Point::where('customer_id', $company_point->customer_id)
                ->where('company_id', $company_point->id)
                ->whereNull('rescue')
                ->where('validity', '>=', $date->format('Y-m-d'))->get();
            
            if (count($points) > 0) {
                $extrato[] = [
                    'company_id' => $company_point->id,
                    'customer_id' => $company_point->customer_id,
                    'company_name' => $company_point->name,
                    'balance' => count($points)
                ];
            }
        }
        
        return view('point.extract', compact('extrato', 'phone_format', 'company'));
    }
    

    public function extractDetail($customer_id, $company_id) {
        $customer = Customer::find($customer_id);
        $company = Company::find($company_id);
        
        if (!$customer || !$company) {
            return redirect('extract')->withErrors(['Empresa ou Cliente não encontrado.']);
        }

        $date = new \DateTime();
        $date->modify("-{$company->months_point_expiration} month");
            

        $points = Point::selectRaw('count(id) as pontos, validity')->where('company_id', $company_id)
                ->where('customer_id', $customer_id)
                ->whereNull('rescue')
                ->where('validity', '>=', $date->format('Y-m-d'))
                ->groupBy('validity')
                ->orderBy('validity')->get();
        

        $total = Point::selectRaw('count(id) as pontos')
                ->where('company_id', $company_id)
                ->whereNull('rescue')
                ->where('validity', '>=', $date->format('Y-m-d'))
                ->where('customer_id', $customer_id)
                ->first();

        return view('point.detail', compact('points', 'company', 'customer', 'total'));
    }
}