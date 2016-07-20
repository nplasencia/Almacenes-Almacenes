<?php

namespace App\Commons;

class ArticleContract extends AppContract {
    const
        TABLE_NAME  = 'articles',
	    SUBGROUP_ID = 'subgroup_id',
        NAME        = 'name',
        CODE        = 'code',
		UNITS       = 'units';
}