<?php

namespace App\Entities;

use App\Commons\PalletContract;
use App\Commons\PalletArticleContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PalletArticle extends Model
{

	// Relations
	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function pallet()
	{
		return $this->belongsTo(Pallet::class);
	}
}
