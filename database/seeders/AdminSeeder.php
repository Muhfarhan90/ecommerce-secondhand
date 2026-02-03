<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@secondhand.com',
            'password' => Hash::make('admin123'),
            'is_active' => true,
        ]);

        $this->command->info('✓ Admin created: admin@secondhand.com / admin123');
    }
}
