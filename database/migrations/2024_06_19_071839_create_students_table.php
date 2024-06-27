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
            $table->char('id', 9)->primary();
            $table->string('name');
            $table->string('place_of_birth');
            $table->timestamp('date_of_birth');
            $table->text('address');
            $table->string('phone_number');
            $table->enum('gender', ['L', 'P']);
            $table->year('stamp');
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
