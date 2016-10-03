<?php

namespace App\Http\Controllers;

use App\Commons\ArticleNewContract;
use App\Commons\Globals;
use App\Commons\PalletArticleContract;
use App\Commons\PalletContract;
use App\Entities\ArticleNew;
use App\Entities\Pallet;
use App\Entities\PalletArticle;
use App\Entities\PalletType;
use App\Repositories\ArticleNewRepository;
use App\Repositories\PalletRepository;
use App\Repositories\StoreRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticlesNewController extends Controller
{
	protected $icon  = 'fa fa-cubes';
	protected $title = 'pages/article_new.title';

	protected $articleNewRepository;
	protected $palletRepository;
	protected $storeRepository;

	public function __construct(ArticleNewRepository $articleNewRepository, PalletRepository $palletRepository, StoreRepository $storeRepository)
	{
		$this->articleNewRepository = $articleNewRepository;
		$this->palletRepository     = $palletRepository;
		$this->storeRepository      = $storeRepository;
	}

	protected function palletValidation(Request $request)
	{
		$this->validate($request, [
			PalletContract::STORE_ID       => 'required|numeric',
			PalletContract::PALLET_TYPE_ID => 'required|string',
			PalletContract::LOCATION       => 'required|string',
		]);
	}

	protected function articleValidation(Request $request)
	{
		$this->validate($request, [
			'newArticle_id' => 'required|numeric',
			'number'        => 'required|numeric',
			'weight'        => 'required|numeric',
			'expiration'    => 'required|date_format:d/m/Y',
		]);
	}

	public function newPallet()
	{
		$stores = $this->storeRepository->getAllByCenter(session('center_id'));
		$palletTypes = PalletType::all();
		return view('pages/articles_new.newPallet', ['title' => trans($this->title), 'icon' => $this->icon, 'stores' => $stores, 'palletTypes' => $palletTypes]);
	}

	public function storeNewPallet(Request $request)
	{
		$this->palletValidation($request);
		$store_id = $request->get(PalletContract::STORE_ID);
		$pallet = $this->palletRepository->newAndStore($request->only([PalletContract::STORE_ID, PalletContract::PALLET_TYPE_ID, PalletContract::LOCATION]));
		$pallet->add($this->palletRepository->getAllByStoreLocationPositionDesc($store_id, $request->get('location')),$store_id, $request->get('location'));

		session()->flash('success', trans('pages/article_new.pallet_create_success',['location' => $pallet->location, 'storeName' => $pallet->store->name]));
		return redirect()->route('articlesNew.addArticlesToPallet',['id' => $pallet->id]);
	}

	public function toAddArticlesView($id)
	{
		$pallet = Pallet::findOrFail($id);
		$lots = $this->articleNewRepository->getAllLots();
		return view('pages/articles_new.addArticles', ['title' => trans($this->title), 'icon' => $this->icon, 'pallet' => $pallet, 'lots' => $lots]);
	}

	public function addArticlesToPallet($id, Request $request)
	{
		$this->articleValidation($request);
		$newArticle = ArticleNew::findOrFail($request->get('newArticle_id'));
		$pallet = Pallet::findOrFail($id);
		$expiration = Carbon::createFromFormat(Globals::CARBON_VIEW_FORMAT, $request->get('expiration'))->format(Globals::CARBON_SQL_FORMAT);
		$pallet->articles()->attach($newArticle->article_id,[PalletArticleContract::LOT        => $newArticle->lot,
															 PalletArticleContract::NUMBER     => $request->get('number'),
															 PalletArticleContract::WEIGHT     => $request->get('weight'),
															 PalletArticleContract::EXPIRATION => $expiration]);

		$restingElements = $newArticle->total - $request->get('number');
		if ($restingElements == 0) {
			$newArticle->delete();
		} else {
			$newArticle->update([ArticleNewContract::TOTAL => $restingElements]);
		}

		session()->flash('success', trans('pages/article_new.article_add_success',['number' => $request->get('number'), 'articleName' => $newArticle->article->name]));
		return redirect()->back();
	}

	public function deletePalletArticle($id)
	{
		$palletArticle = PalletArticle::findOrFail($id);
		$newArticleSaved = $this->articleNewRepository->getByLotAndArticle($palletArticle->lot, $palletArticle->article_id);
		if ($newArticleSaved->trashed()) {
			$newArticleSaved->restore();
			$newArticleSaved->total = $palletArticle->number;
		} else {
			$newArticleSaved->total = $newArticleSaved->total + $palletArticle->number;
		}

		$newArticleSaved->save();
		$palletArticle->delete();
		session()->flash('success', trans('pages/article_new.article_remove_success'));
		return redirect()->back();
	}

	public function getNewArticlesByLot($lot, Request $request)
	{
		$newArticles = $this->articleNewRepository->getByLot($lot);

		if ($request->ajax()) {
			$ajaxResponse = array();
			foreach ($newArticles as $newArticle) {
				$ajaxResponse[] = [$newArticle->id, $newArticle->article->name, $newArticle->total];
			}
			return response()->json($ajaxResponse);
		}

		dd($newArticles);
	}

}
