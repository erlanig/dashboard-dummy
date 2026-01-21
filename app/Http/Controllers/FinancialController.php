<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialController extends Controller
{
    private function isMysql()
    {
        return config('database.default') === 'mysql';
    }

    private function getCurrentDate()
    {
        return $this->isMysql() ? 'CURDATE()' : 'DATE("now")';
    }

    private function dateDiff($date1, $date2)
    {
        if ($this->isMysql()) {
            return "DATEDIFF($date1, $date2)";
        }
        return "CAST((JULIANDAY($date1) - JULIANDAY($date2)) AS INTEGER)";
    }

    public function index()
    {
        // Total Accounts Receivable
        $totalReceivable = DB::table('accounts_receivable')
            ->where('status', '!=', 'paid')
            ->sum('amount');

        // Total Accounts Payable
        $totalPayable = DB::table('accounts_payable')
            ->where('status', '!=', 'paid')
            ->sum('amount');

        // Current Ratio
        $currentRatio = $totalPayable > 0 ? round($totalReceivable / $totalPayable, 2) : 0;

        // Equity Ratio (simplified calculation)
        $equityRatio = $totalPayable > 0 ? round(($totalReceivable / ($totalReceivable + $totalPayable)) * 100, 2) : 0;

        // Debt Equity (simplified)
        $debtEquity = $totalReceivable > 0 ? round(($totalPayable / $totalReceivable) * 100, 2) : 0;

        // DSI (Days Sales Inventory)
        $avgCOGS = DB::table('profit_loss')
            ->where('month', '>=', Carbon::now()->subMonths(3))
            ->avg('cost_of_goods');
        
        $inventoryItems = DB::table('inventory')->get();
        $totalInventoryValue = $inventoryItems->sum(function($item) {
            return $item->quantity * $item->unit_price;
        });
        
        $dsi = $avgCOGS > 0 ? round(($totalInventoryValue / $avgCOGS) * 30, 0) : 0;

        // DSO (Days Sales Outstanding)
        $avgRevenue = DB::table('profit_loss')
            ->where('month', '>=', Carbon::now()->subMonths(3))
            ->avg('revenue');
        
        $dso = $avgRevenue > 0 ? round(($totalReceivable / $avgRevenue) * 30, 0) : 0;

        // DPO (Days Payable Outstanding)
        $dpo = $avgCOGS > 0 ? round(($totalPayable / $avgCOGS) * 30, 0) : 0;

        // Aging Report - Receivable (Compatible with both MySQL and SQLite)
        $currentDate = $this->getCurrentDate();
        $dateDiff = $this->dateDiff($currentDate, 'due_date');
        
        $agingReceivable = DB::table('accounts_receivable')
            ->select(DB::raw("
                CASE 
                    WHEN $dateDiff < 0 THEN 'Current'
                    WHEN $dateDiff BETWEEN 0 AND 30 THEN '1-30'
                    WHEN $dateDiff BETWEEN 31 AND 60 THEN '31-60'
                    WHEN $dateDiff BETWEEN 61 AND 90 THEN '61-90'
                    ELSE '91+'
                END as aging_period,
                SUM(amount) as total_amount
            "))
            ->where('status', '!=', 'paid')
            ->groupBy('aging_period')
            ->get()
            ->keyBy('aging_period');

        // Aging Report - Payable
        $agingPayable = DB::table('accounts_payable')
            ->select(DB::raw("
                CASE 
                    WHEN $dateDiff < 0 THEN 'Current'
                    WHEN $dateDiff BETWEEN 0 AND 30 THEN '1-30'
                    WHEN $dateDiff BETWEEN 31 AND 60 THEN '31-60'
                    WHEN $dateDiff BETWEEN 61 AND 90 THEN '61-90'
                    ELSE '91+'
                END as aging_period,
                SUM(amount) as total_amount
            "))
            ->where('status', '!=', 'paid')
            ->groupBy('aging_period')
            ->get()
            ->keyBy('aging_period');

        // Profit and Loss data
        $profitLoss = DB::table('profit_loss')
            ->select(
                'month',
                'revenue',
                'cost_of_goods',
                'operating_expenses',
                'other_income',
                DB::raw('(revenue - cost_of_goods - operating_expenses + other_income) as net_profit')
            )
            ->orderBy('month')
            ->get();

        // Working Capital Calculation
        $workingCapital = DB::table('profit_loss')
            ->select(
                'month',
                DB::raw('(revenue - cost_of_goods - operating_expenses) as net_working_capital'),
                DB::raw('revenue as gross_working_capital')
            )
            ->orderBy('month')
            ->get();

        return view('financial.dashboard', compact(
            'totalReceivable',
            'totalPayable',
            'currentRatio',
            'equityRatio',
            'debtEquity',
            'dsi',
            'dso',
            'dpo',
            'agingReceivable',
            'agingPayable',
            'profitLoss',
            'workingCapital'
        ));
    }

    public function getChartData()
    {
        // For AJAX requests to update charts dynamically
        $profitLoss = DB::table('profit_loss')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $profitLoss->pluck('month')->map(function($date) {
                return Carbon::parse($date)->format('M');
            }),
            'revenue' => $profitLoss->pluck('revenue'),
            'cogs' => $profitLoss->pluck('cost_of_goods'),
            'expenses' => $profitLoss->plck('operating_expenses'),
            'other_income' => $profitLoss->pluck('other_income'),
            'net_profit' => $profitLoss->map(function($item) {
                return $item->revenue - $item->cost_of_goods - $item->operating_expenses + $item->other_income;
            })
        ]);
    }
}