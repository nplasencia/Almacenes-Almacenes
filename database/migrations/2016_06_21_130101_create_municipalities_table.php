<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Commons\IslandContract;
use App\Commons\MunicipalityContract;

class CreateMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MunicipalityContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(MunicipalityContract::ID);
            $table->unsignedInteger(MunicipalityContract::ISLAND_ID);
            $table->string(MunicipalityContract::NAME);

            $table->foreign(MunicipalityContract::ISLAND_ID)->references(IslandContract::ID)->on(IslandContract::TABLE_NAME)->onDelete('cascade');

            $table->unique( [MunicipalityContract::ISLAND_ID, MunicipalityContract::NAME] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(MunicipalityContract::TABLE_NAME);
    }
}
