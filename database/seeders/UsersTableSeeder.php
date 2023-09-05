<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
           'name' => 'mostafa emad',
            'email' => 'mostafa@google.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
            ]);
    }
}
