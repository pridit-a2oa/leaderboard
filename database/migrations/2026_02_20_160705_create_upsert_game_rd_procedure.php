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
        DB::unprepared('DROP PROCEDURE IF EXISTS UpsertGameRd');
        DB::unprepared('
            CREATE PROCEDURE UpsertGameRd(
                IN p_data MEDIUMTEXT
            )
            BEGIN
                SET @days = CONCAT(DATE(DATE_ADD(NOW(), INTERVAL 7 DAY)), " 08:00:00");

                INSERT INTO game (`key`, data, expiration)
                VALUES ("base_rd", CAST(p_data AS JSON), UNIX_TIMESTAMP(@days))
                ON DUPLICATE KEY UPDATE
                    data = IF(@should_update := (UNIX_TIMESTAMP() > expiration OR data = CAST("[0,0,0,0,0,0,0,0,0,0,0,0,0]" AS JSON)), CAST(p_data AS JSON), data),
                    expiration = IF(@should_update, UNIX_TIMESTAMP(@days), expiration);
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS UpsertGameRd');
    }
};
