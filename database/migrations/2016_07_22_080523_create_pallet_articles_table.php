<?php

use App\Commons\ArticleContract;
use App\Commons\PalletArticleContract;

use App\Commons\PalletContract;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalletArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PalletArticleContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(PalletArticleContract::ID);
	        $table->unsignedInteger(PalletArticleContract::PALLET_ID);
	        $table->unsignedInteger(PalletArticleContract::ARTICLE_ID);
	        $table->string(PalletArticleContract::LOT, 32);
	        $table->integer(PalletArticleContract::NUMBER);
	        $table->double(PalletArticleContract::WEIGHT);
	        $table->date(PalletArticleContract::EXPIRATION);
            $table->timestamps();

	        $table->foreign(PalletArticleContract::PALLET_ID)->references(PalletContract::ID)->on(PalletContract::TABLE_NAME)->onDelete('cascade');
	        $table->foreign(PalletArticleContract::ARTICLE_ID)->references(ArticleContract::ID)->on(ArticleContract::TABLE_NAME)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(PalletArticleContract::TABLE_NAME);
    }
}
