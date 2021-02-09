<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsSeeder extends Seeder {

    public function run() {
        DB::table('products')->insert([
            ['name' => 'Телевизор', 'amount' => 22000,'created_at'=> Carbon::now()],
            ['name' => 'Ноутбук', 'amount' => 25000,'created_at'=> Carbon::now()],
            ['name' => 'Монитор', 'amount' => 12000,'created_at'=> Carbon::now()],
            ['name' => 'Мышь', 'amount' => 500,'created_at'=> Carbon::now()],
            ['name' => 'Клавиатура', 'amount' => 1000,'created_at'=> Carbon::now()],
            ['name' => 'Принтер', 'amount' => 13000,'created_at'=> Carbon::now()]
        ]);
    }

}
