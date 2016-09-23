<?php

namespace App\Entities;

use App\Commons\ArticleNewContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleNew extends Model
{
    use SoftDeletes;

	protected $table = ArticleNewContract::TABLE_NAME;

	protected $fillable = [ArticleNewContract::ARTICLE_ID, ArticleNewContract::LOT, ArticleNewContract::TOTAL, ArticleNewContract::EXPIRATION];

	// Relations
	public function article()
	{
		return $this->belongsTo(Article::class);
	}
}
