<?php

namespace App\Http\Controllers;

use App\Commons\StoreContract;
use App\Entities\Center;
use App\Entities\Store;
use App\Repositories\CenterRepository;
use App\Repositories\MunicipalityRepository;
use App\Repositories\PalletRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;


class CenterController extends Controller
{
    protected $defaultPagination = 25;
    protected $icon        = 'fa fa-building';
    protected $titleResume = 'menu.centers';
    protected $titleNew    = 'pages/center.newTitle';

    protected $centerRepository;
	protected $storeRepository;
    protected $municipalityRepository;
	protected $palletRepository;

    public function __construct(CenterRepository $centerRepository, MunicipalityRepository $municipalityRepository, PalletRepository $palletRepository, StoreRepository $storeRepository)
    {
        $this->centerRepository = $centerRepository;
        $this->municipalityRepository = $municipalityRepository;
	    $this->palletRepository = $palletRepository;
	    $this->storeRepository = $storeRepository;
    }

    protected function genericValidation(Request $request)
    {
        $this->validate($request, [
            'name'            => 'required|string',
            'municipality_id' => 'required|numeric',
            'address'         => 'string',
            'address2'        => 'string',
            'postalCode'      => 'numeric'
        ]);
    }

    protected function getTableActionButtons(Center $center)
    {
        return '<div class="btn-group">
                    <a href="'.route('center.details', $center->id).'" data-toggle="tooltip" data-original-title="'.trans('general.edit').'" data-placement="bottom" class="btn btn-success btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                
                <div class="btn-group">
                    <a href="'.route('center.delete', $center->id).'" data-toggle="tooltip" data-original-title="'.trans('general.remove').'" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>';
    }

    public function ajaxResume()
    {
        return Datatables::of($this->centerRepository->getAll())
            ->addColumn('emptySpace', function (Center $center) {
                return $center->emptySpace();
            })
            ->addColumn('actions', function (Center $center) {
                return $this->getTableActionButtons($center);
            })
            ->make(true);
    }

    public function resume()
    {
        $centers = $this->centerRepository->getAllPaginated($this->defaultPagination);
        return view('pages.centers.resume', ['title' => trans($this->titleResume), 'icon' => $this->icon, 'centers' => $centers]);
    }

    public function create()
    {
        $municipalities = $this->municipalityRepository->getAll();
        return view('pages.centers.details', ['title' => trans($this->titleNew), 'icon' => $this->icon, 'municipalities' => $municipalities,]);
    }

    public function details($id)
    {
        $center = $this->centerRepository->findOrFail($id);
        $municipalities = $this->municipalityRepository->getAll();
        $title = trans('pages/center.detailsTitle', ['Center' => $center->name, 'Municipality' => $center->municipality->name, 'Island' => $center->municipality->island->name]);
        return view('pages.centers.details', ['title' => $title, 'icon' => $this->icon, 'municipalities' => $municipalities, 'center' => $center]);
    }

    public function store(Request $request)
    {
        $this->genericValidation($request);
        try {
            $center = $this->centerRepository->create($request->only(['name', 'address', 'address2', 'municipality_id', 'postalCode']));
			// Hemos de crear también el almacén de picking para cada centro
	        $this->storeRepository->create([StoreContract::CENTER_ID => $center->id, StoreContract::NAME => Store::PickingName, StoreContract::COLUMNS => 0,
	                                        StoreContract::ROWS => 0, StoreContract::LONGITUDE => 0]);
            session(['center_id'], $center);
            session()->flash('success', trans('pages/center.store_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
        } catch (\PDOException $exception) {
            session()->flash('info', trans('pages/center.store_exists', ['Name' => $request->get('name')]));
        } finally {
            return Redirect::route('center.resume');
        }
    }

    public function update(Request $request, $id)
    {
        $this->genericValidation($request);
        $center = $this->centerRepository->update($id, $request->only(['name', 'address', 'address2', 'municipality_id', 'postalCode']));
        session()->flash('success', trans('pages/center.update_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
        return Redirect::route('center.details', $center->id);
    }

    public function delete($id)
    {
        $center = $this->centerRepository->deleteById($id);
        if (session('center_id') == $id) {
            session()->forget('center_id');
        }
        session()->flash('success', trans('pages/center.delete_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
        return $this->resume();
    }

    public function change(Request $request)
    {
        session(['center_id' => $request->get('center_id')]);
        return Redirect::back();
    }

	public function seeEmptySpace()
	{
		$center = Center::findOrFail(session('center_id'));
		$storesLocations = array();
		foreach ($center->stores as $store) {
			$storesLocations[ $store->name ] = $store->getPalletPositions( true );
		}

		return view('pages.centers.pallets_detail', ['title' => trans('pages/center.emptySpaceTitle',['Center' => $center->name]),
		                                             'icon' => $this->icon, 'storesLocations' => $storesLocations]);
	}
}
