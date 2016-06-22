<?php

namespace App\Repositories;

use App\Commons\CenterContract;
use App\Commons\MunicipalicityContract;
use App\Entities\Center;

class CenterRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new Center();
    }

    public function getAllPaginated($numberOfElements)
    {
        return $this->newQuery()->orderBy(CenterContract::NAME, 'ASC')->with('municipality')->paginate($numberOfElements);
    }

    public function update($id, array $data)
    {
        $center = $this->findOrFail($id);
        $center->name            = $data[CenterContract::NAME];
        $center->municipality_id = $data[CenterContract::MUNICIPALITY_ID];
        $center->address         = $data[CenterContract::ADDRESS];
        $center->address2        = $data[CenterContract::ADDRESS2];
        $center->postalcode      = $data[CenterContract::POSTALCODE];
        $center->update();
        return $center;
    }

    public function searchPaginated($item, $numberOfElements)
    {
        return $this->newQuery()->orderBy(CenterContract::NAME, 'ASC')->with('municipality')
                ->where(CenterContract::NAME, 'LIKE', '%'.$item.'%')
                ->orWhere(CenterContract::ADDRESS, 'LIKE', '%'.$item.'%')
                ->orWhere(CenterContract::ADDRESS2, 'LIKE', '%'.$item.'%')
                ->paginate($numberOfElements);

        /*
         return DB::table(CenterContract::TABLE_NAME)
                   ->join(MunicipalicityContract::TABLE_NAME, 'centers.municipality_id', '=', 'municipalities.id')
                   ->join(IslandContract::TABLE_NAME, 'municipalities.island_id', '=', 'islands.id')
                   ->where('centers.name', 'LIKE', '%'.$item.'%')
                   ->orWhere(CenterContract::ADDRESS, 'LIKE', '%'.$item.'%')
                   ->orWhere(CenterContract::ADDRESS2, 'LIKE', '%'.$item.'%')
                   ->orWhere('municipalities.name', 'LIKE', '%'.$item.'%')
                   ->orWhere('islands.name', 'LIKE', '%'.$item.'%')
                   ->orderBy('centers.name')->paginate($numberOfElements);
         */
    }
    
    
}