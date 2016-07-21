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
	    $query = "SELECT articles.id, articles.name, article_subgroups.name as subgroup, article_groups.name as groupName, COUNT(pallets.id) as sum FROM articles
						INNER JOIN article_subgroups ON articles.subgroup_id = article_subgroups.id 
						INNER JOIN article_groups ON article_subgroups.group_id = article_groups.id 
						INNER JOIN pallet_articles ON articles.id=pallet_articles.article_id 
						INNER JOIN pallets ON pallets.id=pallet_articles.pallet_id 
						INNER JOIN stores ON stores.id=pallets.store_id
					WHERE stores.center_id=$center_id
					GROUP BY articles.id, articles.name, subgroup, groupName
					ORDER BY articles.name";
		return $this->getEntity()->hydrateRaw($query);

    }

	public function getAllPaginatedByCenter($center_id, $numberOfElements)
	{
		return $this->getAll()->where(StoreContract::CENTER_ID, $center_id)->get($numberOfElements);
	}

	public function findComplexById($id, $center_id)
	{
		return DB::table(ArticleContract::TABLE_NAME)
		         ->join(ArticleSubGroupContract::TABLE_NAME, 'articles.subgroup_id', '=', 'article_subgroups.id')
		         ->join(ArticleGroupContract::TABLE_NAME, 'article_subgroups.group_id', '=', 'article_groups.id')
		         ->join(PalletArticleContract::TABLE_NAME, 'articles.id', '=', 'pallet_articles.article_id')
		         ->join(PalletContract::TABLE_NAME, 'pallets.id', '=', 'pallet_articles.pallet_id')
		         ->join(StoreContract::TABLE_NAME, 'stores.id', '=', 'pallets.store_id')
				 ->where(StoreContract::CENTER_ID, $center_id)
				 ->where('articles.id', $id)
		         ->select(DB::raw('pallet_articles.lot as lot, pallet_articles.number as number, (pallet_articles.number * pallet_articles.weight) as totalWeight,
		                           stores.name as storeName, pallets.location as location, pallets.position as position, pallet_articles.expiration as expiration,
		                           pallet_articles.created_at as created_at'))->get();
	}
    
}