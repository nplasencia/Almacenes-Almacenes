<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;

class DashboardController extends Controller
{

    protected $icon  = 'fa fa-dashboard';
    protected $title = 'menu.dashboard';

	protected $articleRepository;
    
    public function __construct(ArticleRepository $articleRepository)
    {
	    $this->articleRepository = $articleRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $expiredArticles      = $this->articleRepository->getNextToExpire(session('center_id'), 100);
	    $lastInsertedArticles = $this->articleRepository->getLastInserted(session('center_id'), 100);

	    $viewArray = ['Mercancía próxima a caducarse' => $expiredArticles, 'Últimas entradas de mercancía' => $lastInsertedArticles];
	    return view('dashboard', ['title' => trans($this->title), 'icon' => $this->icon, 'viewArray' => $viewArray]);
    }
}
