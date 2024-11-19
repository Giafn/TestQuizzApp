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
        Schema::create('answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('quizz_id')->constrained()->onDelete('cascade');
            $table->enum('visibility', ['private', 'public']);
            $table->foreignUlid('class_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['passed', 'fail', 'ungraded']);
            $table->enum('grading_status', ['onproccess', 'done']);
            $table->integer('pts')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
