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
                'disclaimer' => 'With Steam we can verify your in-game identity by matching a 17-digit unique identifier, enabling character linking',
            ],
        ]);
    }
}
