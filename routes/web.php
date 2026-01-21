<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinancialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('financial.dashboard');
});

Route::get('/financial/dashboard', [FinancialController::class, 'index'])
    ->name('financial.dashboard');

Route::get('/financial/chart-data', [FinancialController::class, 'getChartData'])
    ->name('financial.chart-data');