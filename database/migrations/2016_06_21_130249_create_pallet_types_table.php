<?php

use App\Commons\PalletTypeContract;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalletTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PalletTypeContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(PalletTypeContract::ID);
            $table->string(PalletTypeContract::NAME);
            $table->unsignedSmallInteger(PalletTypeContract::WIDTH);
            $table->unsignedSmallInteger(PalletTypeContract::LARGE);

            $table->unique( [PalletTypeContract::NAME] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(PalletTypeContract::TABLE_NAME);
    }
}
