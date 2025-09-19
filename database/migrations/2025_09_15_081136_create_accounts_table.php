<?php
// database/migrations/xxxx_xx_xx_create_accounts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id'); // multi-tenant
            $table->string('name'); // e.g. Cash at Hand, Fees Income
            $table->string('code')->nullable(); // optional: "1001", "4001"
            
            // Asset, Liability, Equity, Income, Expense
            $table->enum('category', ['asset', 'liability', 'equity', 'income', 'expense']);
            
            // Default balance type (Dr or Cr) based on category
            $table->enum('normal_balance', ['debit', 'credit']);
            
            $table->boolean('is_default')->default(false); // mark system-created accounts
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
