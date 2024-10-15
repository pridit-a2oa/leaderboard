<?php

namespace Database\Seeders;

use App\Models\MuteReason;
use Illuminate\Database\Seeder;

class MuteReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MuteReason::insert([
            [
                'name' => 'advertising',
                'description' => 'Player joined for the sole purpose of advertisement',
            ],

            [
                'name' => 'disruptive',
                'description' => 'Offensive or argumentative communication (mild but persistent)',
            ],

            [
                'name' => 'toxic',
                'description' => 'Racist or bigoted communication (heinous)',
            ],
        ]);
    }
}
