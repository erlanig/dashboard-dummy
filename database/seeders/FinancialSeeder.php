<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Accounts Receivable Data
        DB::table('accounts_receivable')->insert([
            ['invoice_number' => 'INV-2025-001', 'customer_name' => 'PT Maju Jaya', 'amount' => 850000, 'invoice_date' => '2025-01-15', 'due_date' => '2025-01-20', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2025-002', 'customer_name' => 'CV Sukses Mandiri', 'amount' => 1200000, 'invoice_date' => '2025-01-10', 'due_date' => '2025-02-10', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2025-003', 'customer_name' => 'PT Global Tech', 'amount' => 450000, 'invoice_date' => '2024-12-20', 'due_date' => '2025-01-15', 'status' => 'overdue', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2025-004', 'customer_name' => 'UD Sejahtera', 'amount' => 320000, 'invoice_date' => '2025-01-05', 'due_date' => '2025-02-05', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2024-145', 'customer_name' => 'PT Indo Karya', 'amount' => 680000, 'invoice_date' => '2024-12-15', 'due_date' => '2025-01-10', 'status' => 'overdue', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2024-150', 'customer_name' => 'CV Berkah', 'amount' => 920000, 'invoice_date' => '2024-12-01', 'due_date' => '2024-12-31', 'status' => 'overdue', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2025-005', 'customer_name' => 'PT Digital Asia', 'amount' => 1500000, 'invoice_date' => '2025-01-18', 'due_date' => '2025-02-18', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2025-006', 'customer_name' => 'UD Makmur', 'amount' => 270000, 'invoice_date' => '2025-01-12', 'due_date' => '2025-03-12', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2024-148', 'customer_name' => 'PT Nusantara', 'amount' => 410000, 'invoice_date' => '2024-11-20', 'due_date' => '2024-12-20', 'status' => 'overdue', 'created_at' => now(), 'updated_at' => now()],
            ['invoice_number' => 'INV-2025-007', 'customer_name' => 'CV Gemilang', 'amount' => 560000, 'invoice_date' => '2025-01-20', 'due_date' => '2025-04-20', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Accounts Payable Data
        DB::table('accounts_payable')->insert([
            ['bill_number' => 'BILL-2025-001', 'vendor_name' => 'PT Supplier Utama', 'amount' => 350000, 'bill_date' => '2025-01-18', 'due_date' => '2025-01-25', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['bill_number' => 'BILL-2025-002', 'vendor_name' => 'CV Material Jaya', 'amount' => 480000, 'bill_date' => '2025-01-15', 'due_date' => '2025-02-15', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['bill_number' => 'BILL-2024-089', 'vendor_name' => 'PT Logistik Prima', 'amount' => 125000, 'bill_date' => '2024-12-28', 'due_date' => '2025-01-15', 'status' => 'overdue', 'created_at' => now(), 'updated_at' => now()],
            ['bill_number' => 'BILL-2025-003', 'vendor_name' => 'UD Bahan Baku', 'amount' => 290000, 'bill_date' => '2025-01-10', 'due_date' => '2025-02-10', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['bill_number' => 'BILL-2024-085', 'vendor_name' => 'PT Distributor Mega', 'amount' => 175000, 'bill_date' => '2024-12-10', 'due_date' => '2025-01-05', 'status' => 'overdue', 'created_at' => now(), 'updated_at' => now()],
            ['bill_number' => 'BILL-2025-004', 'vendor_name' => 'CV Sumber Makmur', 'amount' => 210000, 'bill_date' => '2025-01-20', 'due_date' => '2025-03-20', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Inventory Data
        DB::table('inventory')->insert([
            ['product_name' => 'Product A', 'quantity' => 150, 'unit_price' => 50000, 'last_updated' => '2025-01-20', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product B', 'quantity' => 230, 'unit_price' => 75000, 'last_updated' => '2025-01-19', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product C', 'quantity' => 180, 'unit_price' => 120000, 'last_updated' => '2025-01-18', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product D', 'quantity' => 95, 'unit_price' => 200000, 'last_updated' => '2025-01-20', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product E', 'quantity' => 320, 'unit_price' => 35000, 'last_updated' => '2025-01-17', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product F', 'quantity' => 140, 'unit_price' => 90000, 'last_updated' => '2025-01-20', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product G', 'quantity' => 270, 'unit_price' => 45000, 'last_updated' => '2025-01-19', 'created_at' => now(), 'updated_at' => now()],
            ['product_name' => 'Product H', 'quantity' => 110, 'unit_price' => 150000, 'last_updated' => '2025-01-18', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Profit Loss Data (12 months)
        $profitLossData = [
            ['2024-01-01', 1200000, 500000, 350000, 150000],
            ['2024-02-01', 1450000, 580000, 380000, 100000],
            ['2024-03-01', 1380000, 520000, 420000, 80000],
            ['2024-04-01', 1680000, 650000, 450000, 100000],
            ['2024-05-01', 950000, 420000, 380000, 50000],
            ['2024-06-01', 1820000, 720000, 490000, 90000],
            ['2024-07-01', 1420000, 550000, 410000, 60000],
            ['2024-08-01', 1650000, 640000, 440000, 70000],
            ['2024-09-01', 1580000, 610000, 460000, 90000],
            ['2024-10-01', 2100000, 820000, 520000, 115000],
            ['2024-11-01', 2520000, 980000, 560000, 125000],
            ['2024-12-01', 2350000, 920000, 540000, 135000],
        ];

        foreach ($profitLossData as $data) {
            DB::table('profit_loss')->insert([
                'month' => $data[0],
                'revenue' => $data[1],
                'cost_of_goods' => $data[2],
                'operating_expenses' => $data[3],
                'other_income' => $data[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Financial data seeded successfully!');
    }
}