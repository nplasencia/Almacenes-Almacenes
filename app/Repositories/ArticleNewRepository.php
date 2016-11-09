<?php

namespace App\Repositories;

use App\Commons\ArticleNewContract;
use App\Commons\CenterContract;
use App\Commons\StoreContract;
use App\Entities\ArticleNew;
use App\Entities\Center;
use App\Entities\PalletArticle;
use Illuminate\Support\Facades\DB;

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

	public function getByCenterId($centerId = null)
	{
		$query = DB::table(ArticleNewContract::TABLE_NAME)
			       ->join(StoreContract::TABLE_NAME, 'articles_new.store_id', '=', 'stores.id')
			       ->join(CenterContract::TABLE_NAME, 'stores.center_id', '=', 'centers.id')
				   ->select('articles_new.*')->where('articles_new.deleted_at', null);
		if ($centerId != null) {
			$query = $query->where('centers.id', $centerId);
		}
		return $query->get();
	}
}