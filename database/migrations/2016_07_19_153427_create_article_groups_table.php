<?php

use App\Commons\ArticleGroupContract;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(ArticleGroupContract::TABLE_NAME, function (Blueprint $table) {
		    $table->increments(ArticleGroupContract::ID);
		    $table->string(ArticleGroupContract::CODE,16)->unique();
		    $table->string(ArticleGroupContract::NAME);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop(ArticleGroupContract::TABLE_NAME);
    }
}
