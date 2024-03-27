<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::before(function ($user, $ability, $arguments) {
            if (str_starts_with($ability, 'access_')) {
                // Check if user has access to the specific permission based on some condition (e.g., status)
                $permissionName = str_replace('access_', '', $ability);
                return $user->hasAccessToPermission($permissionName);
            }
        });
    }
}
