<?php

namespace App\Http\Controllers;

use App\Http\Requests\RescuePointRequest;
use App\Http\Requests\StorePointRequest;
use App\Models\Company;
use App\Services\CreatePoint;
use App\Services\CalculatePoint;
use App\Models\Customer;
use App\Models\Point;
use Auth;
use Illuminate\Http\Request;

class PointController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $company = Auth::user()->company()->first();
        return view('point.create', compact('company'));
    }

    public function store(StorePointRequest $request)
    {
        try {
            $user = Auth::user();
            $company = Auth::user()->company()->first();
            
            $points = $this->dispatch(new CreatePoint($request, $company, $user));
            $phone =  preg_replace("/[^0-9]/", "", $request->input('phone'));

            $customer = Customer::where('phone', $phone)->first();

            return redirect()->back()->with([
                'success' => "Pontos lançados: {$points} ponto(s).",
                'customer_id' => $customer->id
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function calculate(Request $request)
    {
        $company = Auth::user()->company()->first();
        $points = $this->dispatch(new CalculatePoint($request->input('price'), $company ));
        
        return response()->json([
            'pontos' => $points
        ]);
    }

    public function formRescue()
    {
        return view('point.formRescue');
    }


    public function rescue(RescuePointRequest $request) 
    {
        $company = Auth::user()->company()->first();

        $phone =  preg_replace("/[^0-9]/", "", $request->phone);
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer || !$company) {
            return redirect()->back()->with([
                'warning' => "Cliente não encontrado"
            ]);
        }

        $date = new \DateTime();
        $date->modify("-{$company->months_point_expiration} month");

        $total = Point::selectRaw('count(id) as pontos')
            ->where('company_id', $company->id)
            ->whereNull('rescue')
            ->where('validity', '>=', $date->format('Y-m-d'))
            ->where('customer_id', $customer->id)
            ->first();
            
        if ($request->points > $total->pontos) {
            return redirect()->back()->with([
                'warning' => "Saldo de pontos não permite resgate. Cliente possui {$total->pontos} pontos."
            ]);
        }

        $pontos = Point::where('company_id', $company->id)
            ->whereNull('rescue')
            ->where('validity', '>=', $date->format('Y-m-d'))
            ->where('customer_id', $customer->id)
            ->take($request->points)
            ->orderBy('id')->update(['rescue' => new \DateTime()]);

        return redirect()->back()->with([
            'success' => "Resgate efetuado com sucesso",
            'customer_id' => $customer->id
        ]);
    }
}
