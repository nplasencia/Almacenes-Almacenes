<?php

namespace App\Entities;

use App\Commons\AlfagesMovementsContract;

use Illuminate\Database\Eloquent\Model;

class AlfagesMovement extends Model
{
    protected $fillable = [AlfagesMovementsContract::STORE, AlfagesMovementsContract::DATE, AlfagesMovementsContract::DOCUMENT,
                           AlfagesMovementsContract::ARTICLE, AlfagesMovementsContract::QUANTITY, AlfagesMovementsContract::LOT];

}
