<?php

use Illuminate\Database\Seeder;
use App\Entities\ArticleNew;

class ArticleNewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    factory(ArticleNew::class, 100)->create();
    }
}
