<?php

namespace App\Entities;

use App\Commons\MunicipalityContract;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    public $timestamps = false;

    protected $fillable = [MunicipalityContract::ISLAND_ID, MunicipalityContract::ISLAND_ID];

    public function centers()
    {
        return $this->hasMany(Center::class);
    }

    public function island()
    {
        return $this->belongsTo(Island::class);
    }
}
