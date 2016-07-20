<?php

namespace App\Http\Controllers;

use App\Entities\PalletArticle;
use App\Repositories\ArticleRepository;
use App\Repositories\PalletRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;

class PalletArticleController extends Controller
{
	protected $defaultPagination = 25;
	protected $icon        = 'fa fa-cubes';
	protected $titleResume = 'menu.centers';
	protected $titleNew    = 'pages/center.newTitle';

    protected $palletRepository;
	protected $articleRepository;

    public function __construct(PalletRepository $palletRepository, ArticleRepository $articleRepository)
    {
        $this->palletRepository = $palletRepository;
	    $this->articleRepository = $articleRepository;
    }

	protected function getTableActionButtons($article)
	{
		return '<div class="btn-group">
                    <a href="'.route('center.details', $article->id).'" data-toggle="tooltip" data-original-title="'.trans('general.edit').'" data-placement="bottom" class="btn btn-success btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                
                <div class="btn-group">
                    <a href="'.route('center.delete', $article->id).'" data-toggle="tooltip" data-original-title="'.trans('general.remove').'" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>';
	}

	public function ajaxResume()
	{
		return Datatables::of($this->articleRepository->getAllByCenter(session('center_id')))
						->addColumn('actions', function ($article) {
							//return $this->getTableActionButtons($article);
							return 'pene';
						})
						->make(true);
	}

	public function resume()
	{
		$articles = $this->articleRepository->getAllPaginatedByCenter(session('center_id'), $this->defaultPagination);
		return view('pages.pallet_articles.resume', ['title' => trans($this->titleResume), 'icon' => $this->icon, 'articles' => $articles]);
	}
}
