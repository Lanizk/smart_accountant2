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
        Schema::create('extra_fee_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('extrafee_id')->constrained('extrafees')->onDelete('cascade'); // Links to extra fee
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('quantity',8,2);
            $table->decimal('total_fee',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extrafeeclasses');
    }
};
