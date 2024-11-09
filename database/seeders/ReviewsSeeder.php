<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Looping untuk isi data review 10 baju
        for ($i = 1; $i <= 10; $i++) {
            //Looping dengan jumlah dirandom, berapa review comment
            for ($j = 0; $j < rand(1,5); $j++) {
                DB::table('reviews')->insert([
                    'name' => fake()->firstName(),
                    'review' => fake()->realText(),
                    'clothes_id' => $i,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }  
    }
}
