<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lowrider.com'],
            [
                'name' => 'Admin LowRider',
                'password' => 'password',
                'is_admin' => true,
            ]
        );
    }
}
