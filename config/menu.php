<?php

use App\Commons\Roles;

return array (

    'items' => array (
        'menu.dashboard'     => array('link' => 'dashboard', 'icon' => 'fa fa-dashboard', 'auth' => null),
        'menu.centers'       => array('link' => 'center.resume', 'icon' => 'fa fa-building', 'auth' => Roles::SUPER_ADMIN),
        'menu.stores'        => array('link' => 'store.resume', 'icon' => 'fa fa-th', 'auth' => Roles::ADVANCED),
        'menu.palletArticle' => array('link' => 'palletArticle.resume', 'icon' => 'fa fa-cubes', 'auth' => null),
    )
);