<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS UpsertCharacterGear');
        DB::unprepared('
            CREATE PROCEDURE UpsertCharacterGear(
                IN p_character_id INT,
                IN p_data MEDIUMTEXT
            )
            BEGIN
                INSERT INTO character_gear (character_id, data)
                VALUES (p_character_id, CAST(p_data AS JSON))
                ON DUPLICATE KEY UPDATE data = CAST(p_data AS JSON);
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS UpsertCharacterGear');
    }
};
