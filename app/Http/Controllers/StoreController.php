<?php

namespace App\Http\Controllers;

use App\Commons\StoreContract;
use App\Entities\Store;
use App\Repositories\PalletRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;

class StoreController extends Controller
{
    protected $defaultPagination = 25;
    protected $icon              = 'fa fa-th';
    protected $titleResume       = 'menu.stores';
    protected $titleNew          = 'pages/store.newTitle';

	protected $palletRepository;
	protected $storeRepository;

    public function __construct(PalletRepository $palletRepository, StoreRepository $storeRepository)
    {
	    $this->palletRepository = $palletRepository;
        $this->storeRepository = $storeRepository;
    }

    protected function genericValidation(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string',
            'rows'      => 'required|numeric',
            'columns'   => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    }

    protected function getTableActionButtons(Store $store)
    {
        return '<div class="btn-group">
                    <a href="'.route('store.details', $store->id).'" data-toggle="tooltip" data-original-title="'.trans('general.edit').'" data-placement="bottom" class="btn btn-success btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                
                <div class="btn-group">
                    <a href="'.route('store.delete', $store->id).'" data-toggle="tooltip" data-original-title="'.trans('general.remove').'" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>';
    }

    public function ajaxResume()
    {
	    $user = Auth::user();

        $dataTables = Datatables::of($this->storeRepository->getAllWithoutPickingByCenter(session('center_id')))
	            ->addColumn('totalSpace', function(Store $store){
	                return $store->totalSpace();
	            })
	            ->addColumn('usedSpace', function(Store $store){
	                return '<a href="'.route('store.usedSpace', $store->id).'" data-toggle="tooltip" data-original-title="'.trans('pages/store.seeUsedSpace').'" data-placement="bottom">
	                            '.$store->usedSpace().'
	                       </a>';
	            })
	            ->addColumn('emptySpace', function(Store $store){
	                return '<a href="'.route('store.usedSpace', $store->id).'" data-toggle="tooltip" data-original-title="'.trans('pages/store.seeEmptySpace').'" data-placement="bottom">
	                            '.$store->emptySpace().'
	                       </a>';
	            });

	    if ($user->isAdmin()) {
		    $dataTables->addColumn( 'actions', function ( Store $store ) {
			    return $this->getTableActionButtons( $store );
		    } );
	    }

	    return $dataTables->make(true);
    }

    public function resume()
    {
        $stores = $this->storeRepository->getAllWithoutPickingByCenter(session('center_id'), $this->defaultPagination);
        return view('pages.stores.resume', ['title' => trans($this->titleResume), 'icon' => $this->icon, 'stores' => $stores]);
    }

    public function create()
    {
        return view('pages.stores.details', ['title' => trans($this->titleNew), 'icon' => $this->icon]);
    }

    public function details($id)
    {
        $store = $this->storeRepository->findOrFail($id);
        $title = trans('pages/store.detailsTitle', ['Store' => $store->name]);
        return view('pages.stores.details', ['title' => $title, 'icon' => $this->icon, 'store' => $store]);
    }

    public function store(Request $request)
    {
        $this->genericValidation($request);
        try {
            $store = $this->storeRepository->create([
                'name'      => $request->get(StoreContract::NAME),
                'center_id' => session('center_id'),
                'rows'      => $request->get(StoreContract::ROWS),
                'columns'   => $request->get(StoreContract::COLUMNS),
                'longitude' => $request->get(StoreContract::LONGITUDE)
            ]);
            session()->flash('success', trans('pages/store.store_success',['Name' => $store->name]));
        } catch (\PDOException $exception) {
            session()->flash('info', trans('pages/store.store_exists', ['Name' => $request->get(StoreContract::NAME)]));
        } finally {
            return Redirect::route('store.resume');
        }
    }

    public function update(Request $request, $id)
    {
        $this->genericValidation($request);
        $store = $this->storeRepository->update($id, $request->only('name', 'rows', 'columns', 'longitude'));
        session()->flash('success', trans('pages/store.update_success',['Name' => $store->name]));
        return Redirect::route('store.details', $store->id);
    }

    public function delete($id)
    {
        $store = $this->storeRepository->deleteById($id);
        session()->flash('success', trans('pages/store.delete_success',['Name' => $store->name]));
        return $this->resume();
    }

	public function seeEmptySpace($id)
	{
		$store = $this->storeRepository->findOrFail($id);
		$locations = $store->getPalletPositions();

		return view('pages.stores.pallets_detail', ['title' => "Detalle del almacén {$store->name}", 'icon' => $this->icon, 'positions' => $locations, 'store' => $store]);
	}

    public function seeUsedSpace($id)
    {
		$store = $this->storeRepository->findOrFail($id);
	    $locations = $store->getPalletPositions();

	    foreach ($locations as $location => $values) {
	    	if ($values['used'] == 0) {
	    		unset($locations[ $location ]);
		    }
	    }

	    return view('pages.stores.pallets_detail', ['title' => "Detalle del almacén {$store->name}", 'icon' => $this->icon, 'positions' => $locations, 'store' => $store]);
    }
}
