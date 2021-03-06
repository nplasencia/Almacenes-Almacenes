<?php

namespace App\Entities;

use App\Commons\ArticleGroupContract;

use App\Commons\ArticleSubGroupContract;
use Illuminate\Database\Eloquent\Model;

class ArticleGroup extends Model
{
	public $timestamps = false;

    protected $fillable = [ArticleGroupContract::CODE, ArticleGroupContract::NAME];

	public function subgroups()
	{
		return $this->hasMany(ArticleSubGroup::class, ArticleSubGroupContract::GROUP_ID);
	}

}
