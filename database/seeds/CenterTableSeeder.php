<?php

use App\Commons\StoreContract;
use App\Entities\Center;
use App\Entities\Store;
use Illuminate\Database\Seeder;

class CenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Center::class, 100)->create()->each(function($center) {
        	$picking = new Store([StoreContract::NAME => Store::PickingName, StoreContract::COLUMNS => 0,
	                              StoreContract::ROWS => 0, StoreContract::LONGITUDE => 0]);
	        $center->stores()->save($picking);
        });
    }
}
