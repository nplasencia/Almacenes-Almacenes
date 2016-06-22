<?php

namespace App\Http\Controllers;

use App\Repositories\MunicipalityRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\CenterRepository;
use Illuminate\Support\Facades\Redirect;

class CenterController extends Controller
{
    protected $defaultPagination = 25;
    protected $icon        = 'fa fa-building';
    protected $titleResume = 'menu.centers';
    protected $titleNew    = 'pages/center.newCenterTitle';
    protected $searchRoute = 'center.search';

    protected $centerRepository;
    protected $municipalityRepository;

    public function __construct(CenterRepository $centerRepository, MunicipalityRepository $municipalityRepository)
    {
        $this->centerRepository = $centerRepository;
        $this->municipalityRepository = $municipalityRepository;
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
    
    public function resume($centers)
    {
        return view('pages.centers.resume', ['title' => trans($this->titleResume), 'icon' => $this->icon, 'centers' => $centers,
                                             'searchRoute' => $this->searchRoute, 'paginationClass' => $centers]);
    }

    public function all()
    {
        $centers = $this->centerRepository->getAllPaginated($this->defaultPagination);
        return $this->resume($centers);
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
            session()->flash('success', trans('pages/center.store_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
        } catch (\PDOException $exception) {
            session()->flash('info', trans('pages/center.store_exists', ['Name' => $request->get('name')]));
        } finally {
            return Redirect::route('center.create');
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
        session()->flash('success', trans('pages/center.delete_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
        return $this->all();
    }

    public function search(Request $request)
    {
        if ($request->get('item') != '') {
            $centers = $this->centerRepository->searchPaginated($request->get('item'), $this->defaultPagination);

            if (sizeof($centers) != 0) {
                return $this->resume($centers);
            }
            session()->flash('info', trans('pages/center.search_no_found'));
        }
        return $this->all();
    }
}
