<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user.list', 'user.create', 'user.edit', 'user.delete',
            'role.list', 'role.create', 'role.edit', 'role.delete',
            'permission.list', 'permission.create', 'permission.edit', 'permission.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Cajero']);
        Role::firstOrCreate(['name' => 'Cocinero']);
        Role::firstOrCreate(['name' => 'Mesero']);
    }
}
