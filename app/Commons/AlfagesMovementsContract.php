<?php

namespace App\Commons;

class AlfagesMovementsContract extends AppContract {
    const
        TABLE_NAME  = 'alfages_movements',
        STORE       = 'store',
        DATE        = 'date',
	    TYPE        = 'type',
        DOCUMENT    = 'document',
        ARTICLE     = 'article',
        QUANTITY    = 'quantity',
		LOT         = 'lot';
}