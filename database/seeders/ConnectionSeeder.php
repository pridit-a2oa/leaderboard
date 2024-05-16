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
            ],
        ]);
    }
}
