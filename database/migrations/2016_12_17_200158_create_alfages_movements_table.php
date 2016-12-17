<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Commons\AlfagesMovementsContract;

class CreateAlfagesMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(AlfagesMovementsContract::TABLE_NAME, function (Blueprint $table) {
		    $table->increments(AlfagesMovementsContract::ID);
		    $table->string(AlfagesMovementsContract::STORE);
		    $table->date(AlfagesMovementsContract::DATE);
		    $table->string(AlfagesMovementsContract::TYPE);
		    $table->string(AlfagesMovementsContract::DOCUMENT);
		    $table->string(AlfagesMovementsContract::ARTICLE);
		    $table->integer(AlfagesMovementsContract::QUANTITY);
		    $table->integer(AlfagesMovementsContract::LOT);
		    $table->timestamps();

		    $table->unique([AlfagesMovementsContract::STORE, AlfagesMovementsContract::DATE, AlfagesMovementsContract::TYPE, AlfagesMovementsContract::DOCUMENT,
			                AlfagesMovementsContract::ARTICLE, AlfagesMovementsContract::QUANTITY, AlfagesMovementsContract::LOT]);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop(AlfagesMovementsContract::TABLE_NAME);
    }
}
