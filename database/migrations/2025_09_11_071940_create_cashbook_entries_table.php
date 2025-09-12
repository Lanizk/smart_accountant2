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
        Schema::create('cashbook_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->enum('transaction_type', ['inflow','outflow']); 
            $table->string('entry_type')->default('original'); // original, reversal, restored, adjustment
            $table->unsignedBigInteger('source_id')->nullable();   // polymorphic source id
            $table->string('source_type')->nullable();             // polymorphic source type (App\Models\Expense, App\Models\Income...)
            $table->unsignedBigInteger('related_entry_id')->nullable(); // link reversal/restored to original
            $table->decimal('amount', 15, 2);
            $table->string('payment_method')->nullable();
            $table->date('transaction_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['school_id']);
            $table->index(['source_type','source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashbook_entries');
    }
};
