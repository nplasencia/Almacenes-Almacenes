<?php

namespace App\Entities;

use App\Commons\PalletContract;
use App\Commons\PalletArticleContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pallet extends Model
{
    use SoftDeletes;

    protected $fillable = [PalletContract::STORE_ID, PalletContract::PALLET_TYPE_ID, PalletContract::LOCATION, PalletContract::POSITION];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function articles()
    {
    	return $this->belongsToMany(Article::class, PalletArticleContract::TABLE_NAME)
		    ->withPivot(PalletArticleContract::LOT, PalletArticleContract::NUMBER, PalletArticleContract::WEIGHT, PalletArticleContract::EXPIRATION);
    }
}
