<?php

namespace Database\Seeders;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Preference::insert([
            [
                'name' => 'steam',
                'description' => 'Hide public <component-link title="Steam Community" href="https://steamcommunity.com" size="2xs"></component-link> profile link displayed next to my linked characters',
            ],

            [
                'name' => 'gravatar',
                'description' => 'Override avatar with <component-link title="Gravatar" href="https://support.gravatar.com/basic/where-appear/" size="2xs"></component-link> for my linked characters (requires email)',
            ],
        ]);
    }
}
