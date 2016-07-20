<?php

use App\Entities\ArticleSubGroup;
use App\Commons\ArticleSubGroupContract;

use Illuminate\Database\Seeder;

class ArticleSubGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subGroups = [  [1,'EM','Embutidos'], [1,'JM','Jamón'], [1,'PV','Pavo'], [2,'50','Fruta IQF'], [2,'PF','Puré de Frutas'], [2,'SM','Smoothie'],
				        [3,'99','Hielo'], [4,'MJ','Mojitos'], [5,'15','Natas'], [5,'MN','Mantequilla'], [5,'NM','Margarina'], [5,'QU','Quesos'],
				        [6,'EL','Prod. Mexicanos Elaborados'], [6,'FJ','Fajitas'], [6,'MJ','Productos Mejicanos'], [6,'MS','Salsas Mejicanos'],
				        [6,'VA','Varios'], [7,'PB','Pasta Congelada'], [8,'PL','Pollo'], [9,'KB','Kebab'], [9,'PA','Elaborados Panadería'],
				        [9,'PE','Pescados'], [9,'PL','Pollo'], [9,'PO','Porcino'], [9,'PQ','Pastelería nacional'], [9,'PS','Repostería'],
				        [9,'PT','Ternera'], [9,'VA','Producto Inglés'], [9,'VR','Varios'], [10,'FF','Papa FF'], [10,'P3','Papa 3/8'],
				        [10,'PC','Papas Ecofrost'], [10,'PE','Papas Económicas'], [10,'PL','Papas Lutosa'], [10,'PM','Papa McCain'],
				        [11,'30','Precocinado Industrial'], [12,'PZ','Pizzas'], [13,'MH','Mayonesas'], [13,'PB','Pan Bocadillo'], [13,'VA','Varios'],
				        [14,'50','Verdura Industrial'], [14,'MZ','Verduras Mezclas'], [14,'RV','Revueltos'], [14,'VS','Verdura Asiática'],
		             ];

	    foreach ($subGroups as $subGroup) {
		    $articleSubGroup = new ArticleSubGroup([ArticleSubGroupContract::GROUP_ID => $subGroup[0], ArticleSubGroupContract::CODE => $subGroup[1], ArticleSubGroupContract::NAME => $subGroup[2]]);
		    $articleSubGroup->save();
        }
    }
}
