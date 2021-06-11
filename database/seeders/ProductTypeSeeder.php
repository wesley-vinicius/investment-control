<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            ['product_category_id' => 1, 'name' => 'Ações'],
            ['product_category_id' => 1, 'name' => 'Fundo Imo'],
            ['product_category_id' => 2, 'name' => 'CDB'],
            ['product_category_id' => 2, 'name' => 'Tesouro'],
        ]);
    }
}
