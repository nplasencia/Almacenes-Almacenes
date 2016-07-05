<?php

namespace App\Http\ViewComposers;

use App\Repositories\StoreRepository;

use Illuminate\Contracts\View\View;

class CenterEmptySpaceComposer
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function compose(View $view)
    {
        $stores = $this->storeRepository->getAllByCenter(session('center_id'));
        $emptySpace = 0;
        foreach ($stores as $store) {
            $emptySpace += $store->emptySpace();
        }

        $view->with('centerEmptySpace', $emptySpace);
    }
}