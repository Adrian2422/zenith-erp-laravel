<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(10)->withoutTwoFactor()->create([
            'password' => bcrypt('password'),
        ]);

        foreach ($users as $user) {
            $user->assignRole('employee');
        }

        $superuser = User::factory()->withoutTwoFactor()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $superuser->assignRole('admin');
    }
}
