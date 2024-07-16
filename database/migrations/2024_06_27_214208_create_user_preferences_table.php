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
        Schema::create('preference_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('preference_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('value')->default(0);

            $table->unique(['preference_id', 'user_id']);

            $table->foreign('preference_id')->references('id')->on('preferences');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
