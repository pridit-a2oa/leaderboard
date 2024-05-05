<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = collect([
            'links',
            'vanity',
            'enhanced',
            'visibility',
            'reset'
        ]);

        $permissions->each(function ($permission) {
            Permission::create(['name' => $permission]);
        });

        // Default, permission-less role
        Role::create(['name' => 'member']);

        // Contributors with elevated permissions to assign benefits
        Role::create(['name' => 'supporter'])
            ->givePermissionTo(['name' => $permissions]);

        // Admins to inherit all permissions
        Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());
    }
}
