<?php

namespace App\Repositories;

use App\Commons\PalletArticleContract;
use App\Entities\PalletArticle;

class PalletArticleRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new PalletArticle();
    }

    public function existsByLotPalletAndArticle($lot, $pallet_id, $article_id)
    {
		return $this->newQuery()->where(PalletArticleContract::LOT, $lot)->where(PalletArticleContract::PALLET_ID, $pallet_id)
			->where(PalletArticleContract::ARTICLE_ID, $article_id)->first();
    }
}