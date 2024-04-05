<?php

namespace App\Providers;

use App\Enums\GenderType;
use App\Enums\Role;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $roles = new Role();
        $genders = new GenderType();

        View::share('roles', $roles);
        View::share('genders', $genders);
    }
}
