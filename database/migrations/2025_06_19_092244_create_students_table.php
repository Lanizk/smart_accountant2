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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
             $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
             $table->string('name');
             $table->string('phone');
             $table->string('admission');
             $table->enum('gender',['male','female']);
             $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
             $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
