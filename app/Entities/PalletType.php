<?php

namespace App\Entities;

use App\Commons\PalletTypeContract;
use Illuminate\Database\Eloquent\Model;

class PalletType extends Model
{
    public $timestamps = false;

    protected $fillable = [ PalletTypeContract::NAME, PalletTypeContract::LARGE, PalletTypeContract::WIDTH ];
}
