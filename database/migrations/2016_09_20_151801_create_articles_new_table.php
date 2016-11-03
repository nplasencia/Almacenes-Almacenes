<?php

use App\Commons\ArticleContract;
use App\Commons\ArticleNewContract;
use App\Commons\StoreContract;
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
		    $table->unsignedInteger(ArticleNewContract::STORE_ID);
		    $table->string(ArticleNewContract::DOC, 32);
		    $table->string(ArticleNewContract::LOT, 32);
		    $table->integer(ArticleNewContract::TOTAL);
		    $table->date(ArticleNewContract::DATE);
		    $table->date(ArticleNewContract::EXPIRATION)->nullable()->default(null);
		    $table->softDeletes();
		    $table->timestamps();

		    $table->foreign(ArticleNewContract::ARTICLE_ID)->references(ArticleContract::ID)->on(ArticleContract::TABLE_NAME)->onDelete('cascade');
		    $table->foreign(ArticleNewContract::STORE_ID)->references(StoreContract::ID)->on(StoreContract::TABLE_NAME)->onDelete('cascade');

		    $table->unique([ArticleNewContract::STORE_ID, ArticleNewContract::DOC, ArticleNewContract::ARTICLE_ID, ArticleNewContract::LOT]);
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
