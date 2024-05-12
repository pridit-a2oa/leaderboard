<?php

namespace Database\Seeders;

use App\Models\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'icon' => 'steam'
            ],
        ]);
    }
}
