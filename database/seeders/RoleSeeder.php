<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'member',
            'icon' => 'fa-heart-broken',
        ]);

        Role::create([
            'name' => 'supporter',
            'icon' => 'fa-heart',
            'color' => '#026bbe',
        ]);

        Role::create([
            'name' => 'admin',
            'icon' => 'fa-cog',
        ]);
    }
}
