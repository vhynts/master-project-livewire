<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // User Management
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',
            
            // Role Management
            'roles.index',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions($permissions);
        }

        // Root role usually gets all permissions via Gate::before or similar logic, 
        // but we can also assign them explicitly if needed.
        // For now, let's assume root has super admin access handled elsewhere or explicitly assign here too.
        $rootRole = Role::where('name', 'root')->first();
        if ($rootRole) {
            $rootRole->syncPermissions($permissions);
        }
    }
}
