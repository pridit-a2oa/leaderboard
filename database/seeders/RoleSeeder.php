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
        ]);

        Role::create([
            'name' => 'supporter',
        ]);

        Role::create([
            'name' => 'admin',
        ]);
    }
}
