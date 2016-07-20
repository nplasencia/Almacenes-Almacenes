<?php

namespace App\Entities;

use App\Commons\ArticleContract;
use App\Commons\PalletArticleContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [ArticleContract::SUBGROUP_ID, ArticleContract::CODE, ArticleContract::NAME, ArticleContract::UNITS];

	public function subgroup()
	{
		return $this->belongsTo(ArticleSubGroup::class);
	}

	public function pallets()
	{
		return $this->belongsToMany(Pallet::class, PalletArticleContract::TABLE_NAME)
			->withPivot(PalletArticleContract::LOT, PalletArticleContract::NUMBER, PalletArticleContract::WEIGHT, PalletArticleContract::EXPIRATION);;
	}
    
}
