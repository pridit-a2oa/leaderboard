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
        Schema::create('mute_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->mediumText('description');
        });

        Schema::create('mutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reason_id');
            $table->string('id64')->unique();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('reason_id')->references('id')->on('mute_reasons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutes');
        Schema::dropIfExists('mute_reasons');
    }
};
