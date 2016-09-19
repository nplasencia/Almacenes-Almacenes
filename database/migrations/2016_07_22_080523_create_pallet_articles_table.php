<?php

use App\Commons\PalletArticleContract;

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
