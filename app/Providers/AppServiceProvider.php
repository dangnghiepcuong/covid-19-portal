<?php

namespace App\Providers;

use App\Enums\ActionStatus;
use App\Enums\GenderType;
use App\Enums\RegistrationStatus;
use App\Enums\Role;
use App\Enums\Shift;
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
        $shifts = new Shift();
        $registrationStatuses = new RegistrationStatus();
        $actionStatuses = new ActionStatus();

        View::share('roles', $roles);
        View::share('genders', $genders);
        View::share('shifts', $shifts);
        View::share('registrationStatuses', $registrationStatuses);
        View::share('actionStatuses', $actionStatuses);
    }
}
