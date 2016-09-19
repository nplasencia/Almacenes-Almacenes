<?php

namespace App\Http\Controllers;

use App\Commons\PalletContract;
use App\Entities\Pallet;
use App\Repositories\PalletRepository;
use App\Repositories\StoreRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PalletController extends Controller
{
	protected $defaultPagination = 25;
	protected $icon        = 'fa fa-th';
	protected $titleResume = 'pages/store_pallets.title';

	protected $palletRepository;
	protected $storeRepository;

	public function __construct(PalletRepository $palletRepository, StoreRepository $storeRepository)
	{
		$this->palletRepository = $palletRepository;
		$this->storeRepository  = $storeRepository;
	}

	private function getStoreInArrayById(Collection $collection, $id)
	{
		foreach ($collection as  $element) {
			if ($element->id == $id) {
				return $element;
			}
		}
		return null;
	}

	public function resume($store_id, $location)
	{
		$stores = $this->storeRepository->getAllWithoutPickingByCenter(session('center_id'));
		$store = $this->getStoreInArrayById($stores, $store_id);
		$pallets = $this->palletRepository->getAllByStoreLocation($store_id, $location);
		$title = trans($this->titleResume, ['storeName' => $store->name, 'location' => $location]);
		return view('pages.store_pallets.resume', ['title' => $title, 'icon' => $this->icon, 'pallets' => $pallets, 'stores' => $stores]);
	}

	public function transfer(Request $request, $id)
	{
		$pallet = $this->palletRepository->findOrFail($id);
		if ($pallet->store_id == $request->get('store_id') && $pallet->location == $request->get('location')) {
			session()->flash('info', 'Se está moviendo el palé a la misma ubicación. No se hace nada.');
			return back();
		}
		$pallet = $pallet->extract($this->palletRepository->getAllByStoreLocation($pallet->store_id, $pallet->location));

		if ($request->get('store_id') == '') {
			$store = $this->storeRepository->getPickingStoreByCenter(session('center_id'));
			$pallet->update([PalletContract::STORE_ID => $store->id]);
			session()->flash('success', trans('pages/store_pallets.picking_success'));

		} else {
			$store = $this->storeRepository->findOrFail($request->get('store_id'));
			$pallet->add($this->palletRepository->getAllByStoreLocationPositionDesc($store->id, $request->get('location')),$store->id, $request->get('location'));
			session()->flash('success', trans('pages/store_pallets.transfer_success',['storeName' => $store->name, 'location' => $pallet->location, 'position' => $pallet->position]));
		}

		return back();
	}

	public function getPalletLocationsByStore($store_id, Request $request)
	{
		$store = $this->storeRepository->findOrFail($store_id);
		$locations = $store->getPalletPositions(true);

		if ($request->ajax()) {
			$ajaxResponse = array();
			foreach ($locations as $location => $values) {
				$ajaxResponse[] = $location;
			}
			return response()->json($ajaxResponse);
		}

		dd($locations);
	}
}
