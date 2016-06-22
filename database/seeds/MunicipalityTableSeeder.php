<?php

use Illuminate\Database\Seeder;

use App\Entities\Municipality;
use App\Commons\MunicipalityContract;

class MunicipalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipalities = [ [1,'El Pinar de El Hierro'],[1,'Frontera'],[1,'Valverde'],
                            [2,'Antigua'],[2,'Betancuria'],[2,'La Oliva'],[2,'Pájara'],[2,'Puerto del Rosario'],[2,'Tuineje'],
                            [3,'Agaete'],[3,'Agüimes'],[3,'Artenara'],[3,'Arucas'],[3,'Firgas'],[3,'Gáldar'],[3,'Ingenio'],[3,'La Aldea de San Nicolás'],[3,'Las Palmas de Gran Canaria'],[3,'Mogán'],[3,'Moya'],[3,'San Bartolomé de Tirajana'],[3,'Santa Brígida'],[3,'Santa Lucía de Tirajana'],[3,'Santa María de Guía'],[3,'Tejeda'],[3,'Telde'],[3,'Teror'],[3,'Valleseco'],[3,'Valsequillo'],[3,'Vega de San Mateo'],
                            [4,'Agulo'],[4,'Alajeró'],[4,'Hermigua'],[4,'San Sebastián de la Gomera'],[4,'Valle Gran Rey'],[4,'Vallehermoso'],
                            [5,'Barlovento'],[5,'Breña Alta'],[5,'Breña Baja'],[5,'El Paso'],[5,'Fuencaliente'],[5,'Garafía'],[5,'Los Llanos de Aridane'],[5,'Punta Gorda'],[5,'Puntallana'],[5,'San Andrés y Sauces'],[5,'Santa Cruz de La Palma'],[5,'Tazacorte'],[5,'Tijarafe'],[5,'Villa de Mazo'],
                            [6,'Arrecife'],[6,'Haría'],[6,'San Bartolomé'],[6,'Teguise'],[6,'Tías'],[6,'Tinajo'],[6,'Yaiza'],
                            [7,'Adeje'],[7,'Arafo'],[7,'Arico'],[7,'Arona'],[7,'Buenavista del Norte'],[7,'Candelaria'],[7,'El Rosario'],[7,'El Sauzal'],[7,'El Tanque'],[7,'Fasnia'],[7,'Garachico'],[7,'Granadilla de Abona'],[7,'Guía de Isora'],[7,'Güímar'],[7,'Icod de los Vinos'],[7,'La Guancha'],[7,'La Matanza de Acentejo'],[7,'La Orotava'],[7,'La Victoria de Acentejo'],[7,'Los Realejos'],[7,'Los Silos'],[7,'Puerto de la Cruz'],[7,'San Cristóbal de La Laguna'],[7,'San Juan de la Rambla'],[7,'San Miguel de Abona'],[7,'Santa Cruz de Tenerife'],[7,'Santa Úrsula'],[7,'Santiago del Teide'],[7,'Tacoronte'],[7,'Tegueste'],[7,'Vilaflor']
                          ];

        foreach ($municipalities as $municipalityData) {
            $municipality = new Municipality([MunicipalityContract::ISLAND_ID => $municipalityData[0], MunicipalityContract::NAME => $municipalityData[1]]);
            $municipality->save();
        }
    }
}
