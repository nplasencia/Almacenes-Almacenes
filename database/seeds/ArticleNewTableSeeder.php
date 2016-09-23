<?php

use App\Entities\Article;
use App\Entities\Pallet;
use App\Entities\PalletArticle;
use App\Commons\PalletArticleContract;

use Illuminate\Database\Seeder;

class PalletArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $pallets = Pallet::all();
		foreach ($pallets as $pallet) {
			$articlesNumber = random_int(1, 50);
			factory(PalletArticle::class, $articlesNumber)->create([
				PalletArticleContract::PALLET_ID  => $pallet->id,
			]);
		}
    }
}
