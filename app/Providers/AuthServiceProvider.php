<?php

namespace App\Providers;

use App\Entities\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

	    $gate->define('superAdmin', function (User $user) {
		    return $user->isSuperAdmin();
	    });

        $gate->define('admin', function (User $user) {
        	return $user->isAdmin();
        });

	    $gate->define('advancedUser', function (User $user) {
		    return $user->isAdvancedUser();
	    });
    }
}
