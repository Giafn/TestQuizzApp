<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            [
                'name' => 'General',
                'icon' => '/icon/clipboard.png',
                'desc' => 'General knowledge is information that has been accumulated over time through various mediums.',
            ],
            [
                'name' => 'Mathematics',
                'icon' => '/icon/math.png',
                'desc' => 'Mathematics is the study of numbers, quantities, and shapes.',
            ],
            [
                'name' => 'Science',
                'icon' => '/icon/science.png',
                'desc' => 'Science is the study of the natural world.',
            ],
            [
                'name' => 'History',
                'icon' => '/icon/history.png',
                'desc' => 'History is the study of the past.',
            ],
            [
                'name' => 'Geography',
                'icon' => '/icon/geography.png',
                'desc' => 'Geography is the study of the Earth.',
            ],
            [
                'name' => 'Computer Science',
                'icon' => '/icon/computer.png',
                'desc' => 'Computer Science is the study of computers and computational systems.',
            ],
            [
                'name' => 'Sport',
                'icon' => '/icon/sport.png',
                'desc' => 'Sport is physical activity that people do to keep healthy or for enjoyment.',
            ],
            
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
