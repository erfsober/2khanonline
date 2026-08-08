<?php

namespace Database\Seeders;

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
        User::create([
            'phone' => '09387511748',
            'phone_verified_at' => now()
        ]);
        $this->call(AdminSeeder::class);
        $this->call(AboutUsSeeder::class);
        $this->call(ContactUsSeeder::class);

    }
}
