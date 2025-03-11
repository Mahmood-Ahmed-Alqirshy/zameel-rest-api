<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role_id === User::ADMIN;
        });

        Gate::define('manager', function (User $user) {
            return $user->role_id === User::MANAGER;
        });

        Gate::define('academic', function (User $user) {
            return $user->role_id === User::ACADEMIC;
        });

        Gate::define('representer', function (User $user) {
            return $user->role_id === User::REPRESENTER;
        });

        Gate::define('student', function (User $user) {
            return $user->role_id === User::STUDENT;
        });

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });
    }
}
