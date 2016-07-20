<?php

namespace App\Entities;

use App\Commons\ArticleSubGroupContract;

use Illuminate\Database\Eloquent\Model;

class ArticleSubGroup extends Model
{
	public $timestamps = false;

	public $table = ArticleSubGroupContract::TABLE_NAME;

    protected $fillable = [ArticleSubGroupContract::GROUP_ID, ArticleSubGroupContract::CODE, ArticleSubGroupContract::NAME];

	public function articles()
	{
		return $this->hasMany(Article::class);
	}

	public function group()
	{
		return $this->belongsTo(ArticleGroup::class);
	}
}
