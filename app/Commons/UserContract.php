<?php

namespace App\Commons;

class UserContract extends AppContract {
    const
        TABLE_NAME   = 'users',
        NAME         = 'name',
        SURNAME      = 'surname',
        EMAIL        = 'email',
        TELEPHONE    = 'telephone',
        ROLE         = 'role',
        PASSWORD     = 'password',
        CENTER_ID    = 'center_id',
		EMAIL_EACH   = 'email_each_days',
	    EXPIRED_DAYS = 'expired_days',
		LAST_EMAIL   = 'last_email';
}