<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'ar' => 6621280,
            'ap' => 1630270,
            'equity_ratio' => 75.38,
            'debt_equity' => 1.10,
            'dso' => 7,
            'dpo' => 28,
            'dsi' => 10,
            'working_capital' => [
                8000, 18000, 248700, 226000, 203000, 199000,
                305000, 560000, 90000, 323000, 237000, 0
            ]
        ]);
    }
}
