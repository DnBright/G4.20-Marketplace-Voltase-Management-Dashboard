<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminGmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Boss',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);
    }
}
