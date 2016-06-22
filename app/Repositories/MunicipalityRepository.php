<?php

namespace App\Repositories;

use App\Entities\Municipality;
use App\Commons\MunicipalityContract;

class MunicipalityRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new Municipality();
    }

    public function getAll()
    {
        return $this->newQuery()->orderBy(MunicipalityContract::NAME, 'ASC')->get();
    }
}