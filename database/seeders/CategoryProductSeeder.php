<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryProduct::create([
            'name' => 'Baju',
            'description' => 'baju untuk anak',
            'status' => 'active'
        ]);
    }
}
