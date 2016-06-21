<?php

use Illuminate\Database\Seeder;

use App\Commons\UserContract;
use App\Entities\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSuperAdmin();
        factory(User::class, 100)->create();
    }

    private function createSuperAdmin()
    {
        factory(User::class)->create([
            UserContract::NAME      => 'Nauzet',
            UserContract::SURNAME   => 'Plasencia Cruz',
            UserContract::EMAIL     => 'nplasencia@auret.es',
            UserContract::TELEPHONE => '620467068',
            UserContract::ROLE      => 'superAdmin',
            UserContract::PASSWORD  =>  bcrypt('admin'),
        ]);
    }
}
