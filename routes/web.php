<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckCompanyData;
use App\Http\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware([Authenticate::class])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('company', 'CompanyController')->only([
        'create', 'store',
    ]);
    
    Route::middleware([CheckCompanyData::class])->group(function () {
        Route::resource('point', 'PointController')->only([
            'create', 'store'
        ]);
        Route::post('/point/calculate', 'PointController@calculate')->name('point.calculate');
        Route::get('/company/edit', 'CompanyController@edit')->name('company.edit');
        Route::put('/company/edit', 'CompanyController@update')->name('company.update');
        Route::get('/point/rescue', 'PointController@formRescue')->name('point.formRescue');
        Route::post('/point/rescue', 'PointController@rescue')->name('point.rescue');
    });
});

Route::get('/extract/{company_id?}', 'PointCustomerController@extract')->name('customer.extract');
Route::get('/detail-extract/{customer_id}/{company_id}', 'PointCustomerController@extractDetail')
        ->name('customer.extract.detail');
