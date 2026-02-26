<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rank::insert([
            [
                'name' => 'Private',
                'value' => 0,
            ],

            [
                'name' => 'Corporal',
                'value' => 50,
            ],

            [
                'name' => 'Sergeant',
                'value' => 140,
            ],

            [
                'name' => 'Lieutenant',
                'value' => 260,
            ],

            [
                'name' => 'Captain',
                'value' => 430,
            ],

            [
                'name' => 'Major',
                'value' => 670,
            ],

            [
                'name' => 'Colonel',
                'value' => 1000,
            ],
        ]);
    }
}
