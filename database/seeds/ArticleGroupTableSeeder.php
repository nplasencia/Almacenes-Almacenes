<?php

use App\Entities\ArticleGroup;
use App\Commons\ArticleGroupContract;

use Illuminate\Database\Seeder;

class ArticleGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [ ['EM','Embutidos'], ['FR','Frutas congeladas'], ['HI','Hielo'], ['MJ','Mojitos'], ['ML','Lácteos y margarina'],
	                ['MX','Tex Mex'], ['PA','Pastas congeladas precocinadas'], ['PC','Pollo congelado'], ['PI','Productos ingleses'],
	                ['PP','Papas y especialidades'], ['PR','Precocinados'], ['PZ','Pizzas'], ['VA','Varios'], ['VE','Verduras'],
		          ];

	    foreach ($groups as $group) {
		    $articleGroup = new ArticleGroup([ArticleGroupContract::CODE => $group[0], ArticleGroupContract::NAME => $group[1]]);
		    $articleGroup->save();
        }
    }
}
