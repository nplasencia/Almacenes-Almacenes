<?php

namespace App\Helpers;

use Collective\Html\HtmlBuilder as CollectiveHtmlBuilder;
use Illuminate\Support\Facades\Auth;

class HtmlBuilder extends CollectiveHtmlBuilder {

    public function menu ($items)
    {
        if (!is_array($items)) {
            $items = config($items, array());
        }
	    $user = Auth::user();
	    $filteredItems = array();
        foreach ($items as $key => $item) {

			if ($user->canSee($item['auth'])) {
				$filteredItems[$key] = $item;
			}
        }

        return view('partials.menu', ['items' => $filteredItems]);
    }
}