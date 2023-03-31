<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Role::create(['name' => 'user']);

        $admin = User::create([
            'name' => 'Admin Example',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_verified' => true,
        ]);

        $admin->assignRole($roleAdmin);
    }
}
