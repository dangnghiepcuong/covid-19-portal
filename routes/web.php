<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Models\User;
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

Route::get('/', [LandingPageController::class, 'landingPage']);

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::resource('users', UserController::class);

Route::prefix('businesses')
    ->controller(BusinessController::class)
    ->group(function () {
        Route::get('{id}', 'show')->name('user.profile.show');
        Route::post('', 'store')->name('user.profile.store');
        Route::get('{id}/edit', 'edit')->name('user.profile.edit');
        Route::put('{id}', 'update')->name('user.profile.update');
        Route::patch('{id}', 'update')->name('user.profile.change');
        Route::delete('{id}', 'destroy')->name('user.profile.destroy');
    });
