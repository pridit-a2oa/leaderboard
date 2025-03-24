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
                'description' => 'Hide <component-link title="Steam Community Profile" href="https://steamcommunity.com" size="2xs"></component-link> link associated with own linked characters',
            ],

            [
                'name' => 'gravatar',
                'description' => 'Override avatar with <component-link title="Gravatar" href="https://support.gravatar.com/basic/where-appear/" size="2xs"></component-link> for own linked characters (requires email)',
            ],
        ]);
    }
}
