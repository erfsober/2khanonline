<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin with full access
        $superAdmin = Admin::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => 'password',
            ]
        );

    }
}
