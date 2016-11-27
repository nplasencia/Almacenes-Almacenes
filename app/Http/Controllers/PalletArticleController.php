<?php

namespace App\Http\Controllers;

use App\Commons\PalletArticleContract;
use App\Commons\PalletContract;
use App\Entities\Article;
use App\Entities\Pallet;
use App\Entities\PalletArticle;
use App\Repositories\ArticleRepository;
use App\Repositories\PalletArticleRepository;
use App\Repositories\PalletRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;

class PalletArticleController extends Controller
{
	protected $defaultPagination = 25;
	protected $icon        = 'fa fa-cubes';
	protected $titleResume = 'menu.palletArticle';
	protected $titleNew    = 'pages/articles.newTitle';

    protected $palletRepository;
	protected $articleRepository;
	protected $palletArticleRepository;
	protected $storeRepository;

    public function __construct(PalletRepository $palletRepository, ArticleRepository $articleRepository, StoreRepository $storeRepository,
								PalletArticleRepository $palletArticleRepository)
    {
	    $this->articleRepository = $articleRepository;
    	$this->palletRepository = $palletRepository;
	    $this->storeRepository = $storeRepository;
	    $this->palletArticleRepository = $palletArticleRepository;

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
		$stores = $this->storeRepository->getAllWithoutPickingByCenter(session('center_id'));
		$title = trans('pages/pallet_article.detailsTitle', ['Article' => $article->name]);
		return view('pages.pallet_articles.details', ['title' => $title, 'icon' => $this->icon, 'pallets' => $pallets, 'stores' => $stores]);
	}

	/**
	 * Esta función nos permitirá realizar el traspaso de mercancía entre almacenes. Si en el request no tenemos un store_id, lo traspasamos al
	 * almacén de picking.
	 *
	 * @param Request $request
	 * @param $id
	 *
	 * @return mixed
	 */
	public function articleTransfer(Request $request, $id)
	{
		$palletArticle = PalletArticle::findOrFail($id);
		$number = $request->get('number');
		if ($number > 0) {

			if ($number >= $palletArticle->number) {
				$number = $palletArticle->number;
				$palletArticle->delete();
			} else {
				$palletArticle->number = ($palletArticle->number - $number);
				$palletArticle->update();
			}

			if ($request->get('store_id') == '') {
				$pickingStore = $this->storeRepository->getPickingStoreByCenter( session( 'center_id' ) );

				$pallet = $pickingStore->pallets()->firstOrCreate([
					PalletContract::STORE_ID       => $pickingStore->id,
					PalletContract::PALLET_TYPE_ID => null,
					PalletContract::LOCATION       => null,
					PalletContract::POSITION       => null
				]);

				session()->flash('success', trans_choice('pages/pallet_article.picking_success', $number,
					['Number' => $number, 'ArticleName' => $palletArticle->article->name]));

			} else {
				$store = $this->storeRepository->findOrFail($request->get('store_id'));
				$locationPosition = explode(':', $request->get('location'));

				if ($locationPosition[1] == 0) {
					// Movemos a un nuevo palé
					$locationPosition[1] = 1;
					$pallet = new Pallet([PalletContract::STORE_ID => $store->id, PalletContract::PALLET_TYPE_ID => $request->get('palletType_id'),
										  PalletContract::LOCATION => $locationPosition[0], 0]);
					$pallet->save();
					$palletsInLocation = $this->palletRepository->getAllByStoreLocationPositionDesc($store->id, $locationPosition[0]);
					$pallet->add($palletsInLocation, $store->id, $locationPosition[0]);

				} else {
					// Movemos a un palé existente
					$pallet = $this->palletRepository->getFirstByStoreLocationPosition($store->id, $locationPosition[0], $locationPosition[1]);
				}

				session()->flash('success', trans_choice('pages/pallet_article.transfer_success', $number,
					['Number' => $number, 'ArticleName' => $palletArticle->article->name, 'storeName' => $store->name]));

			}

			if ($palletArticle->pallet->articles->count() == 0) {
				$palletsInLocation = $this->palletRepository->getAllByStoreLocationPositionDesc($palletArticle->pallet->store->id, $palletArticle->pallet->location);
				$palletArticle->pallet->extract($palletsInLocation);

				$palletArticle->pallet->delete();
			}

			$newPalletArticle = $this->palletArticleRepository->existsByLotPalletAndArticle($palletArticle->lot, $pallet->id, $palletArticle->article_id);

			if ($newPalletArticle === null) {
				$pallet->articles()->attach( $palletArticle->article, [
					PalletArticleContract::LOT        => $palletArticle->lot,
					PalletArticleContract::NUMBER     => $number,
					PalletArticleContract::EXPIRATION => $palletArticle->expiration,
					PalletArticleContract::WEIGHT     => $palletArticle->weight
				] );
			} else {
				$newPalletArticle->number = $newPalletArticle->number + $number;
				$newPalletArticle->update();
			}

		}
		return back();

	}

	public function getArticleLocationsByStore($store_id, Request $request)
	{
		$store = $this->storeRepository->findOrFail($store_id);
		$locations = $store->getPalletPositions(false);

		if ($request->ajax()) {
			$ajaxResponse = array();
			foreach ($locations as $location => $values) {
				if ($values['empty'] > 0) {
					$ajaxResponse[] = ["$location:0", "$location (Nuevo palé)"];
				}
				for ($i = 0; $i < $values['used']; $i++) {
					$position = $i+1;
					$ajaxResponse[] = ["$location:$position", "$location (Palé posición $position)"];
				}
			}
			return response()->json($ajaxResponse);
		}

		dd($locations);
	}
}
