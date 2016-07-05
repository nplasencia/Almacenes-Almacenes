<?php

namespace App\Repositories;

use App\Commons\CenterContract;
use App\Entities\Center;

class CenterRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new Center();
    }

    public function getAll()
    {
        return $this->newQuery()->orderBy(CenterContract::NAME, 'ASC')->with('municipality.island')->get();
    }

    public function getAllWithoutMunicipalities()
    {
        return $this->newQuery()->orderBy(CenterContract::NAME, 'ASC')->get();
    }

    public function getAllPaginated($numberOfElements)
    {
        return $this->newQuery()->orderBy(CenterContract::NAME, 'ASC')->with('municipality.island')->paginate($numberOfElements);
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
    
}