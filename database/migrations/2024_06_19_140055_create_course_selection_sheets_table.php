<?php

use App\Enums\CssStatus;
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
        Schema::create('course_selection_sheets', function (Blueprint $table) {
            $table->id();
            $table->char('student_id', 9);
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
            $table->char('lecturer_id', 10)
                ->nullable();
            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturers')
                ->onDelete('cascade');
            $table->enum('status', CssStatus::names())
                ->default(CssStatus::waiting->name);
            $table->enum('type', ['odd', 'even']);
            $table->integer('semester');
            $table->year('year');
            $table->integer('max_load');
            $table->string('message')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_selection_sheets');
    }
};
