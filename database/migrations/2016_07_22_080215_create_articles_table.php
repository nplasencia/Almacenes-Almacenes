<?php

use App\Commons\ArticleContract;
use App\Commons\ArticleSubGroupContract;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ArticleContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(ArticleContract::ID);
	        $table->unsignedInteger(ArticleContract::SUBGROUP_ID);
            $table->string(ArticleContract::NAME);
            $table->string(ArticleContract::CODE, 16);
	        $table->string(ArticleContract::UNITS,8);
            $table->softDeletes();
            $table->timestamps();

	        $table->foreign(ArticleContract::SUBGROUP_ID)->references(ArticleSubGroupContract::ID)->on(ArticleSubGroupContract::TABLE_NAME)->onDelete('cascade');
	        $table->unique([ ArticleContract::SUBGROUP_ID, ArticleContract::CODE]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(ArticleContract::TABLE_NAME);
    }
}
