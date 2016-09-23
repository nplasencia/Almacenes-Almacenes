<?php

use App\Commons\StoreContract;
use App\Commons\CenterContract;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(StoreContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(StoreContract::ID);
            $table->unsignedInteger(StoreContract::CENTER_ID);
            $table->string(StoreContract::NAME);
            $table->unsignedSmallInteger(StoreContract::ROWS);
            $table->unsignedSmallInteger(StoreContract::COLUMNS);
            $table->unsignedSmallInteger(StoreContract::LONGITUDE);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign(StoreContract::CENTER_ID)->references(CenterContract::ID)->on(CenterContract::TABLE_NAME)->onDelete('cascade');

            $table->unique( [StoreContract::CENTER_ID, StoreContract::NAME] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(StoreContract::TABLE_NAME);
    }
}
