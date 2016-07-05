<?php

use App\Entities\Store;
use App\Commons\StoreContract;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Store::class, 500)->create();
    }
}
