<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\V1\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'currentUser']);

// api/v1
Route::middleware('auth:sanctum')
    ->group(function () {
        Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
            Route::apiResource('businesses', BusinessController::class);
            Route::apiResource('schedules', ScheduleController::class);
            Route::apiResource('notifications', NotificationController::class);
        });

        Route::group(['prefix' => 'v1/dashboard', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
            Route::get('totalDoses', [DashboardController::class, 'getTotalDoses'])
                ->name('dashboard.total_dose');
            Route::get('totalPeopleWithOnlyFirstDose', [DashboardController::class, 'getTotalPeopleWithOnlyFirstDose'])
                ->name('dashboard.total_people_with_only_first_dose');
            Route::get('totalPeopleWithOverOneDose', [DashboardController::class, 'getTotalPeopleWithOverOneDose'])
                ->name('dashboard.total_people_with_over_one_dose');
            Route::get('totalPeopleWithNoDose', [DashboardController::class, 'getTotalPeopleWithNoDose'])
                ->name('dashboard.total_people_with_no_dose');
        });
    });
