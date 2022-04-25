<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

//Rutas protegidas
Route::group(['middleware' => 'auth:sanctum'], function () {
//User
Route::controller(UserController::class)->group(function () {
    Route::get('user-logout', 'logout');
    Route::get('/validate-sesion', 'validateSesion');
});
//Products
Route::apiResource('products',ProductController::class);
//Invoices
Route::apiResource('invoices', InvoiceController::class);
//Document type
Route::get('document-types',[DocumentTypeController::class,'index']);
//clients
Route::get('clients-by-document',[ClientController::class,'getByDocumentTypeAndNumber']);
Route::apiResource('clients',ClientController::class);
});

//Usuarios no protegidas
Route::controller(UserController::class)->group(function () {
    Route::post('user-login', 'login');
});
