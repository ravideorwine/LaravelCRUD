<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyCRUDController;

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


// Route::view('companies/noaccess', 'companies/noaccess');


// Route::resource('companies', CompanyCRUDController::class)->middleware('checkAge');

// Route::get('companies/checkResponse', function(){

//     return response('hello word', 200)->header('Content/type','text/plain');
    
// });

Route::resource('companies', CompanyCRUDController::class)->middleware('CheckProduct');

Route::post('delete-company', [CompanyCRUDController::class, 'destroy']);

Route::get('company-export',[CompanyCRUDController::class, 'get_company_data'])->name('company.export');

// Route::post('companies/{company}',[CompanyCRUDController::class, 'destroy']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
