<?php

namespace App\Entities;

use App\Commons\StoreContract;

use App\Enums\PaletTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [StoreContract::CENTER_ID, StoreContract::NAME, StoreContract::ROWS, StoreContract::COLUMNS, StoreContract::LONGITUDE];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function emptySpace() {
        return ($this->longitude / PaletTypeEnum::AMERICANO) * $this->rows * $this->columns;
    }
}
