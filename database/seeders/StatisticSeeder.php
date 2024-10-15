<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Statistic::insert([
            [
                'name' => 'Airdrop Requests',
                'icon' => 'parachute-box',
            ],
            [
                'name' => 'Camp Captures',
                'icon' => 'tents',
            ],
            [
                'name' => 'HALO Jumps',
                'icon' => 'plane',
            ],
            [
                'name' => 'IED Defusals',
                'icon' => 'land-mine-on',
            ],
            [
                'name' => 'Incapacitations',
                'icon' => 'heart-pulse',
            ],
            [
                'name' => 'Intelligence Retrievals',
                'icon' => 'file-lines',
            ],
            [
                'name' => 'Suicide Bomber Kills',
                'icon' => 'bomb',
            ],
            [
                'name' => 'Player Revivals',
                'icon' => 'syringe',
            ],
            [
                'name' => 'Vehicle Deconstructions',
                'icon' => 'screwdriver-wrench',
            ],
            [
                'name' => 'Wreck Collections',
                'icon' => 'car-burst',
            ],
        ]);
    }
}
