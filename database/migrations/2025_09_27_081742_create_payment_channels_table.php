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
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id'); // link to tenant
            $table->enum('type', ['paybill', 'till', 'send_money']);
            $table->string('identifier'); // paybill number, till number, or phone number
            $table->string('account_pattern')->nullable(); // e.g. admission no. for paybill
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_channels');
    }
};
