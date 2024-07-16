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
                'disclaimer' => 'Using Steam we can verify your in-game identity by matching a unique identifier, enabling character linking',
            ],
        ]);
    }
}
