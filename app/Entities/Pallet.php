<?php

namespace App\Entities;

use App\Commons\PalletContract;
use App\Commons\PalletArticleContract;

use App\Enums\PalletTypeEnum;
use App\Repositories\PalletRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pallet extends Model
{
    use SoftDeletes;

    protected $fillable = [PalletContract::STORE_ID, PalletContract::PALLET_TYPE_ID, PalletContract::LOCATION, PalletContract::POSITION];

	// Relations

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function articles()
    {
    	return $this->belongsToMany(Article::class, PalletArticleContract::TABLE_NAME)->withTimestamps()
		    ->withPivot(PalletArticleContract::ID, PalletArticleContract::LOT, PalletArticleContract::NUMBER, PalletArticleContract::WEIGHT, PalletArticleContract::EXPIRATION);
    }

    //

	public function getViewTypeAttribute()
	{
		if ($this->pallet_type_id == 1) {
			return '(Palé americano)';
		} else {
			return '(Palé europeo)';
		}
	}

    // Functions

	/**
	 * Este método se encarga de sacar el palé de una ubicación. Cuando esto ocurre:
	 *
	 *    · Los palés posteriores se adelantan una posición.
	 *    · Los palés anteriores se mantienen en su posición.
	 *
	 * @param Pallet $palletToExtract
	 *
	 * @param Collection $palletsInSamePosition. Importante: ordenados de forma creciente en cuanto a posición dentro del palé
	 *
	 * @return Pallet
	 */
	public function extract(Collection $palletsInSamePosition)
	{
		$palletToExtract = $this;
		$palletToExtractLastPosition = $palletToExtract->position;
		$palletToExtract->update([PalletContract::POSITION => 0]);

		foreach ($palletsInSamePosition as $pallet) {
			if ($pallet->position > $palletToExtractLastPosition) {
				$pallet->update([PalletContract::POSITION => $pallet->position - 1]);
			}
		}
		return $palletToExtract;
	}

	/**
	 * Este método se encarga de meter un palé en una nueva ubicación. Por lo tanto, todos los palés de esa nueva ubicación deben de desplazarse una posición
	 * hacia adentro.
	 *
	 * @param Collection $palletsInNewLocation . Importante: ordenados de forma decreciente en cuanto a posición dentro del palé
	 * @param $newStore_id
	 * @param $newLocation
	 *
	 * @return Pallet
	 */
	public function add(Collection $palletsInNewLocation, $newStore_id, $newLocation)
	{
		foreach ($palletsInNewLocation as $pallet) {
			$pallet->update([PalletContract::POSITION => $pallet->position + 1]);
		}

		$this->update([PalletContract::STORE_ID => $newStore_id, PalletContract::LOCATION => $newLocation, PalletContract::POSITION => 1]);
		return $this;
	}
}
