<?php

use App\Http\Controllers\Api\AddItemtocartController;
use App\Http\Controllers\Webcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user-login', [Webcontroller::class,'login']);

Route::post('user-registration', [Webcontroller::class,'register']);

Route::post('user-login', [Webcontroller::class,'login']);

Route::get('all-user', [Webcontroller::class,'alluser']);

// Route::get('user/{id}', [Webcontroller::class,'userinfo']);

Route::post('update-user/{id}', [Webcontroller::class,'updateuser']);

Route::post('add-vehicle', [Webcontroller::class,'addvehicle']);

Route::get('vehicle/show/{id}', [Webcontroller::class,'showvehicle']);

Route::post('vehicle/{id}', [Webcontroller::class,'editvehicle']);

Route::get('vehicle/delete/{id}', [Webcontroller::class,'deletevehicle']);

Route::get('all-vehicle/{user_id}', [Webcontroller::class,'allvehicle']);

Route::get('companys-info/{id}', [Webcontroller::class,'companysinfo']);

Route::get('companys-report-info/{id}', [Webcontroller::class,'companysreportinfo']);

Route::get('companys-services/{id}', [Webcontroller::class,'companyservices']);

Route::post('companys-info', [Webcontroller::class,'addcompany']);

Route::get('all-company', [Webcontroller::class,'allcompany']);

Route::get('companys-info-review/{id}', [Webcontroller::class,'companyreview']);

Route::get('review/{id}', [Webcontroller::class,'review']);

Route::post('rate-company', [Webcontroller::class,'ratecompany']);

Route::get('history/{user_id}', [Webcontroller::class,'history']);

Route::post('report-breakdown', [Webcontroller::class,'reportbreakdown']);

Route::get('services/{id}', [Webcontroller::class,'services']);

Route::get('delete-services/{id}', [Webcontroller::class,'deleteservices']);

Route::get('service-info/{id}', [Webcontroller::class,'serviceinfo']);

Route::post('services', [Webcontroller::class,'addservices']);

Route::post('update-services/{id}', [Webcontroller::class,'updateservices']);

Route::get('providers/{id}', [Webcontroller::class,'providers']);

Route::get('users/{id}', [Webcontroller::class,'users']);

Route::get('requests/{id}', [Webcontroller::class,'requests']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('show-product/{barcode}', [AddItemtocartController::class,'showproduct']);

Route::post('add-items-to-cart', [AddItemtocartController::class,'additem']);

Route::get('show-cart-items/{appreff}', [AddItemtocartController::class,'showcartitems']);

Route::get('get-cart-total/{appreff}', [AddItemtocartController::class,'carttotal']);

Route::get('delete-from-cart/{id}', [AddItemtocartController::class,'delfromcart']);


Route::apiResource('academicyear', AcademicyearController::class);
