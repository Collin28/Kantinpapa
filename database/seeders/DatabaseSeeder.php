<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kantin.id'],
            [
                'name' => 'Admin Kantin',
                'password' => 'password',
                'role' => UserRole::Admin,
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@campus.ac.id'],
            [
                'name' => 'Budi Santoso',
                'password' => 'password',
                'role' => UserRole::User,
                'status' => 'active',
            ]
        );

        $this->call([
            CategorySeeder::class,
            MenuSeeder::class,
        ]);
    }
}
