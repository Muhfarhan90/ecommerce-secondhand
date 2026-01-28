<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Demo Seller',
            'email' => 'seller@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
