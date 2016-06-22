<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Commons\CenterContract;
use App\Commons\MunicipalityContract;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CenterContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(CenterContract::ID);
            $table->string(CenterContract::NAME);
            $table->string(CenterContract::ADDRESS);
            $table->string(CenterContract::ADDRESS2);
            $table->unsignedInteger(CenterContract::MUNICIPALITY_ID);
            $table->unsignedInteger(CenterContract::POSTALCODE);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign(CenterContract::MUNICIPALITY_ID)->references(MunicipalityContract::ID)->on(MunicipalityContract::TABLE_NAME)->onDelete('cascade');

            $table->unique( [CenterContract::MUNICIPALITY_ID, CenterContract::NAME] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(CenterContract::TABLE_NAME);
    }
}