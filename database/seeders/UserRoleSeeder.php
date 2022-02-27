<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Database\Factories\UserRoleFactory;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    const USER_ROLES = [
        'admin',
        'moder',
        'animeshnik',
        'premium'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::USER_ROLES as $roleName) {
            UserRole::factory()->create(['name' => $roleName]);
        }
    }
}
