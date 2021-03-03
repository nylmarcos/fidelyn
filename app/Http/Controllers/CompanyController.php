<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest as Request;
use App\Models\Company;
use Auth;

class CompanyController extends Controller
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
        if ($company) {
            return redirect('/company/edit');
        }

        return view('company.create');
    }

    public function store(Request $request)
    {
        Company::create(array_merge($request->all(), ['user_id' => Auth::user()->id]));
                
        return redirect('/point/create');
    }

    public function edit()
    {
        $company = Auth::user()->company()->first();
        
        return view('company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $company = Auth::user()->company()->first();
        $company->update($request->all());
        
        return redirect()->back()->with([
            'success' => "Dados da empresa atualizado."
        ]);
    }
}
