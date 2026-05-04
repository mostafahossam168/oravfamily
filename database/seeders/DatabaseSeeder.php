<?php

namespace Database\Seeders;

use App\Enums\UserType;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@admin.com',
            'phone' => '01064564850',
            'password' => bcrypt('123456789'),
            'type' => UserType::ADMIN->value,
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@user.com',
            'phone' => '01064564855',
            'password' => bcrypt('123456789'),
            'type' => UserType::USER->value,
        ]);
        $this->call([]);
    }
}
