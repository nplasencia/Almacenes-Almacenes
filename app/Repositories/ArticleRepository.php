<?php

namespace App\Repositories;

use App\Commons\ArticleContract;
use App\Commons\ArticleGroupContract;
use App\Commons\ArticleSubGroupContract;
use App\Commons\PalletArticleContract;
use App\Commons\PalletContract;
use App\Commons\StoreContract;
use App\Entities\Article;
use App\Entities\ArticleSubGroup;
use Illuminate\Support\Facades\DB;

class ArticleRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new Article();
    }

    private function getAll()
    {
    	return DB::table(ArticleContract::TABLE_NAME)
	             ->join(ArticleSubGroupContract::TABLE_NAME, 'articles.subgroup_id', '=', 'article_subgroups.id')
	             ->join(ArticleGroupContract::TABLE_NAME, 'article_subgroups.group_id', '=', 'article_groups.id')
	             ->join(PalletArticleContract::TABLE_NAME, 'articles.id', '=', 'pallet_articles.article_id')
	             ->join(PalletContract::TABLE_NAME, 'pallets.id', '=', 'pallet_articles.pallet_id')
	             ->join(StoreContract::TABLE_NAME, 'stores.id', '=', 'pallets.store_id')
	             ->select(DB::raw('articles.id, articles.name, article_subgroups.name as subgroup, article_groups.name as groupName, count(pallets.id) as sum'))
	             ->groupBy('articles.id','articles.name', 'subgroup', 'groupName');
    }

    public function getAllByCenter($center_id)
    {
        return $this->getAll()->where(StoreContract::CENTER_ID, $center_id)->get();
    }

	public function getAllPaginatedByCenter($center_id, $numberOfElements)
	{
		return $this->getAll()->where(StoreContract::CENTER_ID, $center_id)->get($numberOfElements);
	}
    
}