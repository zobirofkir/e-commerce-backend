<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'zobir',
            'email' => 'zobirofkir19@gmail.com',
            'password' => 'zobir123',
            'role' => 'admin'
        ]);
    }
}
