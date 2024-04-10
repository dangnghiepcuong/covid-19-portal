<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocalRegionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\VaccineLotController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckBusiness;
use App\Http\Middleware\CheckUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'landingPage'])->name('/');

Route::get('/language/{lang}', [LanguageController::class, 'changeLanguage'])->name('locale');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::controller(LocalRegionController::class)->group(function () {
    Route::get('/local/province_list', 'getProvinceList')->name('local.province_list');
    Route::get('/local/district_list', 'getDistrictList')->name('local.district_list');
    Route::get('/local/ward_list', 'getWardList')->name('local.ward_list');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::prefix('admin')
        ->controller(AdminController::class)
        ->middleware([CheckAdmin::class])
        ->group(function () {
            Route::get('', 'index');
        });

    Route::prefix('accounts')
        ->controller(AccountController::class)
        ->group(function () {
            Route::patch('password/change', 'changePassword')
                ->name('accounts.password.update');

            Route::patch('password/reset', 'resetBusinessPassword')
                ->name('accounts.password.reset');
            Route::patch('business', 'updateBusinessAccount')
                ->middleware([CheckBusiness::class])
                ->name('accounts.business.update');

            Route::patch('user', 'updateAccount')
                ->middleware([CheckUser::class])
                ->name('accounts.user.update');
        });

    Route::prefix('users')
        ->controller(UserController::class)
        ->middleware([CheckUser::class])
        ->group(function () {
            Route::get('profile', 'profile')->name('users.profile');
            Route::patch('', 'updateProfile')->name('users.update-profile');
        });
    Route::resource('users', UserController::class)
        ->middleware([CheckUser::class]);

    Route::prefix('businesses')
        ->controller(BusinessController::class)
        ->group(function () {
            Route::get('trashed', 'trashed')->name('businesses.trashed');
            Route::post('restore/{id}', 'restore')->name('businesses.restore');
            Route::get('profile', 'profile')->name('businesses.profile');
        });
    Route::resource('businesses', BusinessController::class)
        ->middleware([CheckBusiness::class]);

    Route::resource('vaccines', VaccineController::class);

    Route::prefix('vaccine-lots')
        ->controller(VaccineLotController::class)
        ->middleware([CheckBusiness::class])
        ->group(function () {
            Route::get('trashed', 'trashed')->name('vaccine-lots.trashed');
            Route::post('restore/{id}', 'restore')->name('vaccine-lots.restore');
            Route::delete('permanently-delete/{id}', 'delete')->name('vaccine-lots.permanently-delete');
        });
    Route::resource('vaccine-lots', VaccineLotController::class)
        ->middleware([CheckBusiness::class]);

    Route::prefix('schedules')
        ->controller(ScheduleController::class)
        ->middleware([CheckBusiness::class])
        ->group(function () {
            Route::get('trashed', 'trashed')->name('schedules.trashed');
            Route::post('restore/{id}', 'restore')->name('schedules.restore');
            Route::delete('permanently-delete/{id}', 'delete')->name('schedules.permanently-delete');
        });
    Route::resource('schedules', ScheduleController::class)
        ->middleware([CheckBusiness::class]);

    Route::prefix('vaccination')
        ->controller(VaccinationController::class)
        ->middleware([CheckUser::class])
        ->group(function () {
            Route::get('', 'index')->name('vaccination.index');
        });
});
