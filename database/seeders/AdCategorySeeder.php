<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Ad;
use App\Models\Category;

class AdCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = Ad::all();
        $categories = Category::all();

        foreach ($ads as $ad) {
            $ad->categories()->attach(
                $categories->random(rand(1,3))->pluck('id')->toArray()
            );
        }
    }
}