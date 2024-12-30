<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PlanInternetController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register'])->name('api.auth.register');
Route::post('auth/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout')->middleware('auth:api');
Route::get('auth/me', [AuthController::class, 'me'])->name('api.auth.me')->middleware('auth:api');

Route::apiResource('usuarios', AuthController::class);
Route::get('usuarios/roles/actives', 'Api\AuthController@roles')->middleware('auth:api');

Route::apiResource('zonas', ZonaController::class);
Route::apiResource('solicitudes', SolicitudController::class);
Route::apiResource('planes', PlanInternetController::class);