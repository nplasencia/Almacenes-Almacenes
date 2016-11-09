<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(IslandTableSeeder::class);
        $this->call(MunicipalityTableSeeder::class);
	    $this->call(UsersTableSeeder::class);
        //$this->call(CenterTableSeeder::class);
        //$this->call(StoreTableSeeder::class);
	    //$this->call(ArticleGroupTableSeeder::class);
	    //$this->call(ArticleSubGroupTableSeeder::class);
	    //$this->call(ArticleTableSeeder::class);
	    $this->call(PalletTypeTableSeeder::class);
	    //$this->call(PalletTableSeeder::class);
	    //$this->call(PalletArticleTableSeeder::class);
	    //$this->call(ArticleNewTableSeeder::class);
    }
}
