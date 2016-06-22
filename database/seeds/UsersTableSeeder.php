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

        factory(User::class)->create([
            UserContract::NAME      => 'Andrés',
            UserContract::SURNAME   => 'Poch Barrera',
            UserContract::EMAIL     => 'andrespbarrera@gmail.com',
            UserContract::TELEPHONE => '687866335',
            UserContract::ROLE      => 'superAdmin',
            UserContract::PASSWORD  =>  bcrypt('admin'),
        ]);

        factory(User::class)->create([
            UserContract::NAME      => 'Mario',
            UserContract::SURNAME   => 'Cruz',
            UserContract::EMAIL     => 'mario@alcruzcanarias.com',
            UserContract::ROLE      => 'superAdmin',
            UserContract::PASSWORD  =>  bcrypt('admin'),
        ]);
    }
}
