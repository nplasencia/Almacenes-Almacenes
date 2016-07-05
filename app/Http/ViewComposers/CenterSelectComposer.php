<?php

namespace App\Http\ViewComposers;

use App\Repositories\CenterRepository;
use Illuminate\Contracts\View\View;

class CenterSelectComposer
{
    protected $centerRepository;

    public function __construct(CenterRepository $centerRepository)
    {
        $this->centerRepository = $centerRepository;
    }

    public function compose(View $view)
    {
        $centers = $this->centerRepository->getAllWithoutMunicipalities();
        if (session('center_id') === null){
            session(['center_id' => $centers[0]->id]);
        }
        $view->with('centersSelect', $centers);
    }
}