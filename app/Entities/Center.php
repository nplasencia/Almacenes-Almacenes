<?php

namespace App\Entities;

use App\Commons\CenterContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use SoftDeletes;

    protected $fillable = [CenterContract::NAME, CenterContract::ADDRESS, CenterContract::ADDRESS2, CenterContract::MUNICIPALITY_ID, CenterContract::POSTALCODE];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function emptySpace()
    {
        $emptySpace = 0;
        foreach ($this->stores as $store) {
            $emptySpace += $store->emptySpace();
        }
        return $emptySpace;
    }
}
