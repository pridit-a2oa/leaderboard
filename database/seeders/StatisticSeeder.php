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
            ['name' => 'Airdrops Requested'],
            ['name' => 'Camps Captured'],
            ['name' => 'IEDs Disarmed'],
            ['name' => 'Intelligence Found'],
            ['name' => 'Suicide Bombers Killed'],
            ['name' => 'Gestures Performed'],
            ['name' => 'Revived Players'],
            ['name' => 'Vehicles Deconstructed'],
            ['name' => 'Wrecks Collected'],
            ['name' => 'Wrecks Rebuilt']
        ]);
    }
}
