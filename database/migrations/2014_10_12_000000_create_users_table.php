<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Commons\UserContract;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserContract::TABLE_NAME, function (Blueprint $table) {
            $table->increments(UserContract::ID);
            $table->string(UserContract::NAME);
            $table->string(UserContract::SURNAME);
            $table->string(UserContract::EMAIL)->unique();
            $table->string(UserContract::TELEPHONE);
            $table->enum(UserContract::ROLE, ['SuperAdmin', 'Admin', 'AdvUser', 'User']);
            $table->string(UserContract::PASSWORD);
            $table->unsignedInteger(UserContract::CENTER_ID)->nullable()->default(null);
            $table->rememberToken();
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
        Schema::drop(UserContract::TABLE_NAME);
    }
}
