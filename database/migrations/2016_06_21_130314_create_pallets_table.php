<?php

use App\Commons\PalletContract;
use App\Commons\StoreContract;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PalletContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(PalletContract::ID);
            $table->unsignedInteger(PalletContract::STORE_ID);
            $table->unsignedInteger(PalletContract::PALLET_TYPE_ID)->nullable();
            $table->string(PalletContract::LOCATION)->nullable();
            $table->unsignedSmallInteger(PalletContract::POSITION)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign(PalletContract::STORE_ID)->references(StoreContract::ID)->on(StoreContract::TABLE_NAME)->onDelete('cascade');
            $table->unique( [PalletContract::STORE_ID, PalletContract::LOCATION, PalletContract::POSITION] );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(PalletContract::TABLE_NAME);
    }
}
