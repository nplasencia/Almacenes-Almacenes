<?php

use Illuminate\Database\Seeder;

use App\Entities\PalletType;
use App\Commons\PalletTypeContract;

class PalletTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $palletTypes = [['Americano', 1, 1], ['Europeo', 1.2, 0.8]];

        foreach ($palletTypes as $palletTypeData) {
            $palletType = new PalletType([PalletTypeContract::NAME  => $palletTypeData[0],
                                          PalletTypeContract::LARGE => $palletTypeData[1],
                                          PalletTypeContract::WIDTH => $palletTypeData[2]]);
            $palletType->save();
        }
    }
}