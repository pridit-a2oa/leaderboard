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
            $table->foreignId('connection_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('identifier')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['connection_id', 'user_id']);
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
