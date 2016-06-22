<?php

use Illuminate\Database\Seeder;

use App\Entities\Center;

class CenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Center::class, 100)->create();
    }
}
