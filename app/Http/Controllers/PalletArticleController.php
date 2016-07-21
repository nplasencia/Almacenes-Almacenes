<?php

namespace App\Http\Controllers;

use App\Commons\StoreContract;
use App\Entities\Article;
use App\Entities\PalletArticle;
use App\Entities\Pallet;
use App\Repositories\ArticleRepository;
use App\Repositories\PalletRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;

class PalletArticleController extends Controller
{
	protected $defaultPagination = 25;
	protected $icon        = 'fa fa-cubes';
	protected $titleResume = 'menu.palletArticle';
	protected $titleNew    = 'pages/articles.newTitle';

    protected $palletRepository;
	protected $articleRepository;
	protected $storeRepository;

    public function __construct(PalletRepository $palletRepository, ArticleRepository $articleRepository, StoreRepository $storeRepository)
    {
	    $this->articleRepository = $articleRepository;
    	$this->palletRepository = $palletRepository;
	    $this->storeRepository = $storeRepository;

    }

	protected function getTableActionButtons($article)
	{
		return '<div class="btn-group">
                    <a href="'.route('palletArticle.details', $article->id).'" data-toggle="tooltip" data-original-title="'.trans('general.info').'" data-placement="bottom" class="btn btn-info btn-xs">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </div>';
	}

	public function ajaxResume()
	{
		return Datatables::of($this->articleRepository->getAllByCenter(session('center_id')))
							->addColumn('actions', function ($article) {
								return $this->getTableActionButtons($article);
							})
							->make(true);
	}

	public function resume()
	{
		$articles = $this->articleRepository->getAllPaginatedByCenter(session('center_id'), $this->defaultPagination);
		return view('pages.pallet_articles.resume', ['title' => trans($this->titleResume), 'icon' => $this->icon, 'articles' => $articles]);
	}

	public function details($id)
	{
		$article = Article::findOrFail($id);
		$pallets = $this->articleRepository->findComplexById($id, session('center_id'));

		$title = trans('pages/pallet_article.detailsTitle', ['Article' => $article->name]);
		return view('pages.pallet_articles.details', ['title' => $title, 'icon' => $this->icon, 'pallets' => $pallets]);
	}
}
