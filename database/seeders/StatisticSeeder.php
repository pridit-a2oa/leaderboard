<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Statistic::insert([
            ['name' => 'Airdrop Requests'],
            ['name' => 'Camp Captures'],
            ['name' => 'HALO Jumps'],
            ['name' => 'IED Defusals'],
            ['name' => 'Incapacitations'],
            ['name' => 'Intelligence Retrievals'],
            ['name' => 'Suicide Bomber Kills'],
            ['name' => 'Player Revivals'],
            ['name' => 'Vehicle Deconstructions'],
            ['name' => 'Wreck Collections']
        ]);
    }
}
