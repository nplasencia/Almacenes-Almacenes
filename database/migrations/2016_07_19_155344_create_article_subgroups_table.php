<?php

use App\Commons\ArticleSubGroupContract;
use App\Commons\ArticleGroupContract;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleSubgroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(ArticleSubGroupContract::TABLE_NAME, function (Blueprint $table) {
			$table->increments(ArticleSubGroupContract::ID);
			$table->unsignedInteger(ArticleSubGroupContract::GROUP_ID);
			$table->string(ArticleSubGroupContract::CODE,16);
			$table->string(ArticleSubGroupContract::NAME);

			$table->foreign(ArticleSubGroupContract::GROUP_ID)->references(ArticleGroupContract::ID)->on(ArticleGroupContract::TABLE_NAME)->onDelete('cascade');
			$table->unique([ArticleSubGroupContract::GROUP_ID, ArticleSubGroupContract::CODE]);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(ArticleSubGroupContract::TABLE_NAME);
	}
}
