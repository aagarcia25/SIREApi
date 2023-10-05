<?php

use App\Http\Controllers\SireApis;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'ApiSire',
], function () {
    Route::post('validacion', [SireApis::class, 'validacion']);
    Route::post('ConsultaPresupuesto', [SireApis::class, 'ConsultaPresupuesto']);
    Route::post('ConsultaPresupuestoAnual', [SireApis::class, 'ConsultaPresupuestoAnual']);

});
