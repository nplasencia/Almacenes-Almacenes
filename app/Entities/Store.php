<?php

namespace App\Entities;

use App\Commons\StoreContract;

use App\Enums\PalletTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\CountValidator\Exception;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [StoreContract::CENTER_ID, StoreContract::NAME, StoreContract::ROWS, StoreContract::COLUMNS, StoreContract::LONGITUDE];

	const PickingName = 'Picking';
    private $usedSpace = null;

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function pallets()
    {
        return $this->hasMany(Pallet::class);
    }

    public function cellSpace()
    {
        return ($this->longitude / PalletTypeEnum::AMERICANO);
    }

    public function totalSpace()
    {
        return ($this->cellSpace() * $this->rows * $this->columns);
    }

    public function usedSpace()
    {
        if ($this->usedSpace === null) {
            $this->usedSpace = $this->pallets()->count();
        }
        return $this->usedSpace;
    }

    public function emptySpace()
    {
    	if ($this->name != 'Picking') {
		    return $this->totalSpace() - $this->usedSpace();
	    }
	    return 0;
    }
    
    public function getAllLocations()
    {
	    $positions = array();
	    for ( $i=0; $i < $this->rows; $i++ ) {
		    for ( $j=0; $j < $this->columns; $j++ ) {
			    $location = "$i-$j";
			    $positions[$location] = ['total' => $this->cellSpace(), 'used' => 0, 'empty' => $this->cellSpace()];
		    }
	    }
	    return $positions;
    }

	public function getPalletPositions($deleteEmpty = false)
	{
		$pallets = $this->pallets;
		$locations = $this->getAllLocations();

		foreach ( $pallets as $pallet ) {
			$locations[ $pallet->location ]['used'] ++;
			$locations[ $pallet->location ]['empty'] --;
			if ( $deleteEmpty && $locations[ $pallet->location ]['empty'] == 0 ) {
				unset( $locations[ $pallet->location ] );
			}
		}
		return $locations;
	}

	//TODO: Creo que no se ha tenido en cuenta el espacio máximo de la celda
	public function getPositionByLocation($location)
	{
		$position = 1;
		foreach ($this->pallets as $pallet) {
			if ($pallet->location == $location) {
				$position++;
			}
		}
		return $position;
	}
}
