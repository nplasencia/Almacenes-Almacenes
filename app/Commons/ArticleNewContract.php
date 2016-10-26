<?php

namespace App\Commons;

class ArticleNewContract extends AppContract {
    const
        TABLE_NAME = 'articles_new',
        ARTICLE_ID = 'article_id',
	    STORE_ID   = 'store_id',
        LOT        = 'lot',
		TOTAL      = 'total',
		EXPIRATION = 'expiration';
}