<?php

use App\Enums\DayChoice;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_selection_sheet_details', function (Blueprint $table) {
            $table->foreignId('course_selection_sheet_id')
                ->references('id')
                ->on('course_selection_sheets')
                ->onDelete('cascade');
            $table->foreignId('lecture_id')
                ->references('id')
                ->on('lectures')
                ->onDelete('cascade');
            $table->foreignId('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');
            $table->foreignId('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');
            $table->char('lecturer_id', 10);
            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturers')
                ->onDelete('cascade');
            $table->integer('limit')
                ->default(40);
            $table->enum('day', DayChoice::names());
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_selection_sheet_details');
    }
};
