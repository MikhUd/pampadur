<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DatingCardSeeder::class);
        $this->call(LikeSeeder::class);
    }
}
