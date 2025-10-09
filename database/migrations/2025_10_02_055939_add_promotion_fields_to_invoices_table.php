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
        
            Schema::table('invoices', function (Blueprint $table) {
            // Explicit tracking fields
            $table->decimal('base_fee', 10, 2)->default(0);
            $table->decimal('balance_forward', 10, 2)->default(0); // arrears
            $table->decimal('credit_forward', 10, 2)->default(0); // overpayment
            
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            
        });
    }
};
