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
        Schema::create('quizz_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('quizz_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['choice', 'answer']);
            $table->text('question');
            $table->string('question_image')->nullable();
            $table->string('image_a')->nullable();
            $table->string('image_b')->nullable();
            $table->string('image_c')->nullable();
            $table->string('image_d')->nullable();
            $table->string('image_e')->nullable();
            $table->string('image_f')->nullable();
            $table->text('choice_a')->nullable();
            $table->text('choice_b')->nullable();
            $table->text('choice_c')->nullable();
            $table->text('choice_d')->nullable();
            $table->text('choice_e')->nullable();
            $table->text('choice_f')->nullable();
            $table->char('right_choice', 1)->nullable();
            $table->text('right_answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizz_questions');
    }
};
