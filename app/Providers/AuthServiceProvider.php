<?php

namespace App\Providers;

use App\Models\customer;
use App\Models\master_package;
use App\Models\package;
use App\Policies\CustomerPolicy;
use App\Policies\MasterPackagePolicy;
use App\Policies\PackagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        master_package::class => MasterPackagePolicy::class,
        package::class => PackagePolicy::class,
        customer::class => CustomerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
