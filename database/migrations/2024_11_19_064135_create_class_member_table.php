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
        Schema::create('class_member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('class_id');
            $table->foreignUuid('user_id');
            $table->timestamp('join_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_member');
    }
};
