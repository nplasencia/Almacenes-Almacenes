<?php

namespace App\Http\ViewComposers;

use App\Repositories\ArticleNewRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MessagesComposer
{
    protected $articleNewRepository;

    public function __construct(ArticleNewRepository $articleNewRepository)
    {
        $this->articleNewRepository = $articleNewRepository;
    }

    public function compose(View $view)
    {
        $centerId = session('center_id');
		$articlesNew = $this->articleNewRepository->getByCenterId($centerId);

        $view->with('alert_messages', $articlesNew);
    }
}