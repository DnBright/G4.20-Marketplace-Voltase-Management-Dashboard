<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin Bursa',
            'email' => 'admin@lowrider.com',
            'password' => \Illuminate\Support\Facades\Hash::make('passwordadmin123'),
            'is_admin' => true,
        ]);
    }
}
