<?php

namespace App\Commons;

class UserContract extends AppContract {
    const
        TABLE_NAME = 'users',
        NAME       = 'name',
        SURNAME    = 'surname',
        EMAIL      = 'email',
        TELEPHONE  = 'telephone',
        ROLE       = 'role',
        PASSWORD   = 'password';
}