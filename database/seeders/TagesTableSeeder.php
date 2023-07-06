<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
           'name' => 'PHP',
            'slug' => str::slug('PHP'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tags')->insert([
           'name' => 'Laravel',
            'slug' => str::slug('Laravel'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
