<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $rootRole = Role::firstOrCreate(['name' => 'root']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create a root user
        $rootUser = User::factory()->create([
            'name' => 'Root User',
            'email' => 'root@example.com',
        ]);
        $rootUser->assignRole($rootRole);

        // Create an admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $adminUser->assignRole($adminRole);

        // Create some user users
        User::factory()->count(10)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });
    }
}
