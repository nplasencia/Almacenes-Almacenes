<?php

namespace App\Entities;

use App\Commons\StoreContract;

use App\Enums\PalletTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [StoreContract::CENTER_ID, StoreContract::NAME, StoreContract::ROWS, StoreContract::COLUMNS, StoreContract::LONGITUDE];

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
        return $this->totalSpace() - $this->usedSpace();
    }
    
    public function getAllPositions()
    {
	    $positions = array();
	    for ( $i=0; $i < $this->rows; $i++ ) {
		    for ( $j=0; $j < $this->columns; $j++ ) {
			    $location = "0$i-0$j";
			    $positions[$location] = ['total' => $this->cellSpace(), 'used' => 0, 'empty' => $this->cellSpace()];
		    }
	    }
	    return $positions;
    }

	public function getPalletPositions($deleteEmpty = false)
	{
		$pallets = $this->pallets;
		$positions = $this->getAllPositions();
		foreach ($pallets as $pallet) {
			$positions[$pallet->location]['used']++;
			$positions[$pallet->location]['empty']--;

			if ($deleteEmpty && $positions[$pallet->location]['empty'] == 0) {
				unset($positions[$pallet->location]);
			}
		}
		return $positions;
	}

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
