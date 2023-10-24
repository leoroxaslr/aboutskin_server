<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Soap',
        ]);

        Category::create([
            'name' => 'Facial Wash',
        ]);

        Category::create([
            'name' => 'Topical Cream',
        ]);

        Category::create([
            'name' => 'Topical Gel',
        ]);

        Category::create([
            'name' => 'Lotion',
        ]);

        Category::create([
            'name' => 'Cream',
        ]);

        Category::create([
            'name' => 'Anti Acne',
        ]);
    }
}
