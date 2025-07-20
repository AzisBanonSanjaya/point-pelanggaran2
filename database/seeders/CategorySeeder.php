<?php

namespace Database\Seeders;

use App\Models\MasterData\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Merokok',
                'point' => 70,
                'type' => 'Berat',
            ],
            [
                'name' => 'Memukul',
                'point' => 50,
                'type' => 'Sedang',
            ],
            [
                'name' => 'Mengejek',
                'point' => 30,
                'type' => 'Ringan',
            ],
        ];

        Category::truncate();
        Category::insert($categories);
    }
}
