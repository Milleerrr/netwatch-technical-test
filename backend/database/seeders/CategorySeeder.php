<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Drama',
            'Comedy',
            'Action',
            'Horror',
            'Sci-Fi',
            'Romance',
            'Adventure',
            'Thriller',
            'Fantasy',
            'Documentary'
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category],
                ['name' => $category]
            );
        }
    }
}
