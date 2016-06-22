<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Commons\IslandContract;

class CreateIslandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(IslandContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(IslandContract::ID);
            $table->string(IslandContract::NAME)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(IslandContract::TABLE_NAME);
    }
}
