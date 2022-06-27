<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'password' => bcrypt('password'),
            'first_name' => 'Oliver',
            'last_name' => 'Carlos',
            'email_address' => 'test@mail.com',
            'email_verified_at' => now()
        ]);
        User::factory()->count(5)->create();
    }
}
