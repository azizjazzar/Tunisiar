<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CompteAlimentationController;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\IAController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::middleware('web')->get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie has been set']);
});


//CLIENT
Route::post('register', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'index']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/login', [UserController::class, 'login']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
Route::post('/users/count', [UserController::class, 'getUserCount']);

Route::get('/client-data', [UserController::class, 'getClientData']);

//actualites
Route::get('/actualites', [ActualiteController::class, 'index']);
Route::post('/actualites', [ActualiteController::class, 'store']);
Route::delete('/actualites/{id}', [ActualiteController::class, 'destroy']);

Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);

//contrat
Route::post('/contracts', [ContractController::class, 'store']);
Route::get('/contracts', [ContractController::class, 'index']);
Route::delete('/contracts/{id}', [ContractController::class, 'destroy']);
Route::get('/contracts/{id}', [ContractController::class, 'show']);
Route::put('/contracts/{id}', [ContractController::class, 'update']);

//compte 
Route::post('/comptealimentation', [AccountController::class, 'store']);
Route::get('comptealimentation', [AccountController::class, 'index']);
Route::post('/update-balance-and-record-credit', [AccountController::class, 'updateBalanceAndRecordCredit']);

Route::get('/solde/{client}', [AccountController::class, 'getSolde']);


Route::resource('/reservations', ReservationController::class);
Route::post('/reservation/{vol}', [ReservationController::class, 'reservation']);

Route::middleware('auth:sanctum')->get('/list_reservations', [ReservationController::class, 'list_reservations']);
Route::middleware('auth:sanctum')->post('/processPayment/{vol}', [PaymentController::class, 'processPayment']);


Route::get('/searchByDestination', [VolController::class, 'searchByDestination']);

//IARoutes
//IARoutes
Route::post('IA',[IAController::class,'GemeniWithText']);
