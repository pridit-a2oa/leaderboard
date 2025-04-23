<?php

namespace Database\Seeders;

use App\Models\Connection;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Connection::insert([
            [
                'name' => 'steam',
                'icon' => 'steam',
                'description' => 'To verify your in-game identity we match a 17-digit unique identifier via <component-link title="Steam" href="https://store.steampowered.com/" size="2xs"></component-link>, enabling character linking.',
                'is_sso' => 1,
            ],
        ]);
    }
}
