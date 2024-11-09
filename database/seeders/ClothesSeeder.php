<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClothesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ["Red", "Green", "Blue", "Black", "White"];
        $sizes= ["S", "M", "L", "XL"];

        for ($i = 0; $i < 10; $i++) {
            DB::table('clothes')->insert([
                'name' => fake()->word(),
                'color' => $colors[rand(0,sizeof($colors)-1)],
                'size' => $sizes[rand(0,sizeof($sizes)-1)],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
