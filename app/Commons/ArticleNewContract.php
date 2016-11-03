<?php

namespace App\Commons;

class ArticleNewContract extends AppContract {
    const
        TABLE_NAME = 'articles_new',
        ARTICLE_ID = 'article_id',
	    STORE_ID   = 'store_id',
	    DOC        = 'doc',
        LOT        = 'lot',
		TOTAL      = 'total',
	    DATE       = 'date',
		EXPIRATION = 'expiration';
}