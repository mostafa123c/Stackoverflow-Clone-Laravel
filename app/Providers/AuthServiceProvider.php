<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user , $ability) {
            if ($user->type == 'super-admin') {
                return true;
            }
        });

        foreach(config('abilities') as $code =>$label ) {
            Gate::define($code , function (User $user) use ($code){
//                if($user->type =='super-admin'){
//                    return true;
//                };
                foreach ($user->roles as $role) {
                    if (in_array($code , $role->abilities)) {
                        return true;
                    }
                }
                return false;
            });
        }
    }
}
