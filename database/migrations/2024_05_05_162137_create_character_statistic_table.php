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
        Schema::create('character_statistic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('statistic_id');
            $table->bigInteger('value')->default(1);

            $table->unique(['character_id', 'statistic_id']);

            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('statistic_id')->references('id')->on('statistics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_statistic');
    }
};
