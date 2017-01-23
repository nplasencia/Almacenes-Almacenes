<?php

namespace App\Entities;

use App\Commons\ArticleNewContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleNew extends Model
{
    use SoftDeletes;

	protected $table = ArticleNewContract::TABLE_NAME;

	protected $fillable = [ArticleNewContract::ARTICLE_ID, ArticleNewContract::CENTER_ID, ArticleNewContract::DOC,
					       ArticleNewContract::LOT, ArticleNewContract::TOTAL, ArticleNewContract::DATE, ArticleNewContract::EXPIRATION];

	// Relations
	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function center()
	{
		return $this->belongsTo(Center::class);
	}
}
