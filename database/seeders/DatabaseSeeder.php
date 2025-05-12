<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $agent = User::first() ?: User::factory()->create([
            'name' => 'Sales Agent',
            'email' => 'sales@coffee.shop',
            'password' => Hash::make('Password123'),
            'email_verified_at' => now(),
        ]);

        // 10 example sales for that agent
        Sale::factory()->count(10)->create([
            'user_id' => $agent->id,
        ]);
    }
}
