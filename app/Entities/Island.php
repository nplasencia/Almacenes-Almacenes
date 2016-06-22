<?php

namespace App\Entities;

use App\Commons\IslandContract;
use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    public $timestamps = false;

    protected $fillable = [ IslandContract::NAME ];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
