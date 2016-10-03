<?php

namespace App\Repositories;

use App\Commons\ArticleNewContract;
use App\Entities\ArticleNew;
use App\Entities\PalletArticle;

class ArticleNewRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new ArticleNew();
    }

	public function getAllLots()
	{
		$articles = $this->newQuery()->select(ArticleNewContract::LOT)->orderBy(ArticleNewContract::LOT)->groupBy(ArticleNewContract::LOT)->get();
		$lots = array();
		foreach ($articles as $article){
			$lots[] = $article->lot;
		}
		return $lots;
	}

	public function getByLot($lot)
	{
		return $this->newQuery()->where(ArticleNewContract::LOT, $lot)->with('article')->get()->sortBy('article.name');
	}

	public function getByLotAndArticle($lot, $article_id)
	{
		return $this->newQuery()->where(ArticleNewContract::LOT, $lot)->where(ArticleNewContract::ARTICLE_ID, $article_id)->withTrashed()->first();
	}
}