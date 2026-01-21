<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Accounts Receivable Table
        Schema::create('accounts_receivable', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50)->unique();
            $table->string('customer_name', 100);
            $table->decimal('amount', 15, 2);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();
        });

        // Accounts Payable Table
        Schema::create('accounts_payable', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number', 50)->unique();
            $table->string('vendor_name', 100);
            $table->decimal('amount', 15, 2);
            $table->date('bill_date');
            $table->date('due_date');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();
        });

        // Inventory Table
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 100);
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->date('last_updated');
            $table->timestamps();
        });

        // Profit Loss Table
        Schema::create('profit_loss', function (Blueprint $table) {
            $table->id();
            $table->date('month');
            $table->decimal('revenue', 15, 2)->default(0);
            $table->decimal('cost_of_goods', 15, 2)->default(0);
            $table->decimal('operating_expenses', 15, 2)->default(0);
            $table->decimal('other_income', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_loss');
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('accounts_payable');
        Schema::dropIfExists('accounts_receivable');
    }
};