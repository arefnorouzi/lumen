<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\CategoryPack\Category;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Category::factory(10)->create();
        for ($i = 100; $i < 1000; $i++)
        {
            DB::table('categories')->insert([
                'cat_title' => "category $i",
                'cat_slug' => "category-$i",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
