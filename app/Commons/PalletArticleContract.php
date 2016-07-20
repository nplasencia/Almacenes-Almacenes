<?php

namespace App\Commons;

class PalletArticleContract extends AppContract {
    const
        TABLE_NAME  = 'pallet_articles',
	    PALLET_ID   = 'pallet_id',
	    ARTICLE_ID  = 'article_id',
	    LOT         = 'lot',
        NUMBER      = 'name',
	    WEIGHT      = 'weight',
        EXPIRATION  = 'expiration';
}