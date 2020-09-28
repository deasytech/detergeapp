<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage.settings', function($user) {
            return $user->hasAnyRole(['admin','manager']);
        });

        Gate::define('manage.accountant', function($user) {
            return $user->hasAnyRole(['admin','manager','accountant']);
        });

        Gate::define('manage.prospect', function($user) {
            return $user->hasAnyRole(['admin','manager','user']);
        });

        Gate::define('manage-staff', function($user) {
            return $user->hasRole('admin');
        });

        Gate::resource('technician', 'App\Policies\VendorPolicy');
        Gate::resource('customer', 'App\Policies\CustomerPolicy');
        Gate::resource('order', 'App\Policies\OrderPolicy');
        Gate::resource('service', 'App\Policies\ServiceTypePolicy');
        Gate::resource('accountant', 'App\Policies\AccountantPolicy');
        Gate::resource('prospect', 'App\Policies\ProspectPolicy');

        Gate::define('edit-staff', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('delete-staff', function($user) {
            return $user->hasRole('admin');
        });
    }
}
