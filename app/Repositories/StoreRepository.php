<?php

namespace App\Repositories;

use App\Commons\StoreContract;
use App\Entities\Store;

class StoreRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new Store();
    }

    public function getAll()
    {
        return $this->newQuery()->orderBy(StoreContract::NAME, 'ASC')->get();
    }

    public function getAllPaginated($numberOfElements)
    {
        return $this->newQuery()->orderBy(StoreContract::NAME, 'ASC')->paginate($numberOfElements);
    }

    public function getAllByCenter($center_id)
    {
        return $this->newQuery()->where(StoreContract::CENTER_ID, $center_id)->orderBy(StoreContract::NAME, 'ASC')->get();
    }


	public function getAllPaginatedByCenter($center_id, $numberOfElements)
	{
		return $this->newQuery()->where(StoreContract::CENTER_ID, $center_id)->orderBy(StoreContract::NAME, 'ASC')->paginate($numberOfElements);
	}

    public function getAllWithoutPickingByCenter($center_id)
    {
    	return $this->newQuery()->where(StoreContract::CENTER_ID, $center_id)->where(StoreContract::NAME, '<>', Store::PickingName)
		    ->orderBy(StoreContract::NAME, 'ASC')->get();
    }

	public function getAllWithoutPickingByCenterPaginated($center_id, $numberOfElements)
	{
		return $this->newQuery()->where(StoreContract::CENTER_ID, $center_id)->where(StoreContract::NAME, '<>', Store::PickingName)
		            ->orderBy(StoreContract::NAME, 'ASC')->paginate($numberOfElements);
	}

    public function update($id, array $data)
    {
        $store = $this->findOrFail($id);
        $store->name      = $data[StoreContract::NAME];
        $store->rows      = $data[StoreContract::ROWS];
        $store->columns   = $data[StoreContract::COLUMNS];
        $store->longitude = $data[StoreContract::LONGITUDE];
        $store->update();
        return $store;
    }

    public function getPickingStoreByCenter($center_id)
    {
    	return $this->newQuery()->where(StoreContract::NAME, Store::PickingName)->where(StoreContract::CENTER_ID, $center_id)->with('pallets')->first();
    }
    
}