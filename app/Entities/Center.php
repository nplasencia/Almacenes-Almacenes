<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

use App\Commons\CenterContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use SoftDeletes;

    protected $fillable = [CenterContract::NAME, CenterContract::ADDRESS, CenterContract::ADDRESS2, CenterContract::MUNICIPALITY_ID, CenterContract::POSTALCODE];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [CenterContract::DELETED_AT];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class)->with('island');
    }
}
