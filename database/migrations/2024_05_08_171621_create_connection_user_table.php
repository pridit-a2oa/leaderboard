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
        Schema::create('connection_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connection_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('identifier')->nullable();
            $table->timestamps();

            $table->foreign('connection_id')->references('id')->on('connections');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection_user');
    }
};
