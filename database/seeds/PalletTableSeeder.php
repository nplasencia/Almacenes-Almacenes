<?php

use App\Entities\Pallet;
use App\Entities\Store;

use App\Commons\PalletContract;

use Illuminate\Database\Seeder;

class PalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    factory(Store::class, 500)
		    ->create()
		    ->each(
		    	function ($store) {
	    	        $storeLocation = random_int(0, $store->rows).'-'.random_int(0, $store->columns);
		            $store->pallets()
			            ->save(factory(Pallet::class)->make([
			                PalletContract::LOCATION => $storeLocation,
			                PalletContract::POSITION => $store->getPositionByLocation($storeLocation),
		                ]));
	            }
            );
    }
}
