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
        CategoryProduct::truncate();
        $kategori = ["kaos", "kaoskaki", "dompet", "jas"];
        foreach ($kategori as $key => $kat) {
            CategoryProduct::create([
                "name" => $kat,
                "description" => "ini kategori $kat",
                "status" => "untuk $kat"
            ]);
        }
    }
}
