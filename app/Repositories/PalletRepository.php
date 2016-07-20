<?php

namespace App\Repositories;

use App\Commons\ArticleContract;
use App\Commons\PalletContract;
use App\Commons\StoreContract;
use App\Entities\Pallet;

class PalletRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new Pallet();
    }

    public function getAllByStore($store_id)
    {
        return $this->newQuery()->where(PalletContract::STORE_ID, $store_id)->with('store')->with('articles')
                    ->orderBy(PalletContract::LOCATION, 'ASC')->orderBy(PalletContract::POSITION, 'ASC')
                    ->get();
    }

    public function getAllPaginatedByStore($store_id, $numberOfElements)
    {
        return $this->newQuery()->where(PalletContract::STORE_ID, $store_id)->with('store')->with('articles')
                    ->orderBy(PalletContract::LOCATION, 'ASC')->orderBy(PalletContract::POSITION, 'ASC')
                    ->paginate($numberOfElements);
    }

	public function getAllByCenter($center_id)
	{
		return $this->newQuery()->with('store')->where(StoreContract::CENTER_ID, $center_id)->with('articles')
		            ->orderBy(ArticleContract::NAME)->get();
	}

	public function getAllPaginatedByCenter($center_id, $numberOfElements)
	{
		return $this->newQuery()->where(StoreContract::CENTER_ID, $center_id)->with('articles')
			->orderBy(ArticleContract::NAME)->paginate($numberOfElements);
	}



    public function update($id, array $data)
    {
        $pallet = $this->findOrFail($id);
        $pallet->store_id = $data[PalletContract::STORE_ID];
        $pallet->update();
        return $pallet;
    }
    
}