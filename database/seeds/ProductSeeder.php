<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'title' => 'Prod One',
            'image_url' => 'https://www.ellementwine.ca/assets/images/contentblock/photos/july.png',
            'description' => 'Prod One',
            'quantity' => 12,
            'min_qty' => 2,
            'buying_price' => 11,
            'selling_price' => 15,
            'product_category_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'title' => 'Prod Two',
            'image_url' => 'https://www.ellementwine.ca/assets/images/contentblock/photos/july.png',
            'description' => 'Prod Two',
            'quantity' => 11,
            'min_qty' => 2,
            'buying_price' => 10,
            'selling_price' => 15,
            'product_category_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'title' => 'Prod Three',
            'image_url' => 'https://www.ellementwine.ca/assets/images/contentblock/photos/july.png',
            'description' => 'Prod Three',
            'quantity' => 10,
            'min_qty' => 2,
            'buying_price' => 9,
            'selling_price' => 15,
            'product_category_id' => 2,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'title' => 'Prod Four',
            'image_url' => 'https://www.ellementwine.ca/assets/images/contentblock/photos/july.png',
            'description' => 'Prod Four',
            'quantity' => 9,
            'min_qty' => 2,
            'buying_price' => 21,
            'selling_price' => 23,
            'product_category_id' => 2,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'title' => 'Prod Five',
            'description' => 'Prod Five',
            'quantity' => 18,
            'min_qty' => 2,
            'buying_price' => 22,
            'selling_price' => 24,
            'product_category_id' => 3,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'title' => 'Prod Six',
            'description' => 'Prod Six',
            'quantity' => 15,
            'min_qty' => 2,
            'buying_price' => 19,
            'selling_price' => 21,
            'product_category_id' => 3,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'title' => 'Prod Seven',
            'description' => 'Prod Seven',
            'quantity' => 13,
            'min_qty' => 2,
            'buying_price' => 18,
            'selling_price' => 22,
            'product_category_id' => 4,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
