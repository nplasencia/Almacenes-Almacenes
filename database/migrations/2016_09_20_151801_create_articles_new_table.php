<?php

use App\Commons\ArticleContract;
use App\Commons\ArticleNewContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(ArticleNewContract::TABLE_NAME, function (Blueprint $table) {
		    $table->increments(ArticleNewContract::ID);
		    $table->unsignedInteger(ArticleNewContract::ARTICLE_ID);
		    $table->string(ArticleNewContract::LOT, 32);
		    $table->integer(ArticleNewContract::TOTAL);
		    $table->date(ArticleNewContract::EXPIRATION)->nullable()->default(null);
		    $table->softDeletes();
		    $table->timestamps();

		    $table->foreign(ArticleNewContract::ARTICLE_ID)->references(ArticleContract::ID)->on(ArticleContract::TABLE_NAME)->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop(ArticleNewContract::TABLE_NAME);
    }
}
