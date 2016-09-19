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

	public function getAllByStoreLocation($store_id, $location)
	{
		return $this->newQuery()->where(PalletContract::STORE_ID, $store_id)->where(PalletContract::LOCATION, $location)->with('articles.subgroup.group')
					->orderBy(PalletContract::POSITION)->get();
	}

	public function getAllByStoreLocationPositionDesc($store_id, $location)
	{
		return $this->newQuery()->where(PalletContract::STORE_ID, $store_id)->where(PalletContract::LOCATION, $location)->with('articles.subgroup.group')
		            ->orderBy(PalletContract::POSITION, 'DESC')->get();
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

	public function getFirstByStoreLocationPosition($store_id, $location, $position)
	{
		return $this->newQuery()->where(PalletContract::STORE_ID, $store_id)->where(PalletContract::LOCATION, $location)
			->where(PalletContract::POSITION, $position)->firstOrFail();
	}

    public function update($id, array $data)
    {
        return $this->findOrFail($id)->update([PalletContract::STORE_ID => $data[PalletContract::STORE_ID]]);
    }
    
}