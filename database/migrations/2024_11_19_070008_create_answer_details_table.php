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
        Schema::create('answer_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('answer_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['choice', 'answer']);
            $table->foreignUuid('quizz_question_id')->constrained()->onDelete('cascade');
            $table->string('choice_answer')->nullable();
            $table->text('answer')->nullable();
            $table->integer('grade')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_details');
    }
};
