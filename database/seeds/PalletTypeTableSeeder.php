<?php

use Illuminate\Database\Seeder;

use App\Entities\Island;
use App\Commons\IslandContract;

class IslandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $islands = ['El Hierro', 'Fuerteventura', 'Gran Canaria', 'La Gomera', 'La Palma', 'Lanzarote', 'Tenerife'];

        foreach ($islands as $name) {
            $island = new Island([IslandContract::NAME => $name]);
            $island->save();
        }
    }
}
