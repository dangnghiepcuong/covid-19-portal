<?php

use App\Http\Controllers\Api\UserController;
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
        Route::prefix('v1')
            ->namespace('App\Http\Controllers\Api\V1')
            ->group(function () {
                Route::apiResource('businesses', BusinessController::class);
                Route::apiResource('schedules', ScheduleController::class);
                Route::prefix('notifications')
                    ->controller('NotificationController')
                    ->group(function () {
                        Route::get('', 'index');
                        Route::get('countUnread', 'countUnread');
                        Route::post('markAllAsRead', 'markAllAsRead');
                    });

                Route::prefix('dashboard')
                    ->controller('DashboardController')
                    ->group(function () {
                        Route::get('totalDoses', 'getTotalDoses')
                            ->name('dashboard.total_dose');
                        Route::get('totalPeopleWithOnlyFirstDose', 'getTotalPeopleWithOnlyFirstDose')
                            ->name('dashboard.total_people_with_only_first_dose');
                        Route::get('totalPeopleWithOverOneDose', 'getTotalPeopleWithOverOneDose')
                            ->name('dashboard.total_people_with_over_one_dose');
                        Route::get('totalPeopleWithNoDose', 'getTotalPeopleWithNoDose')
                            ->name('dashboard.total_people_with_no_dose');
                        Route::get('monthlyVaccinationData', 'getMonthlyVaccinationData')
                            ->name('dashboard.monthly_vaccination_data');
                        Route::get('vaccinationUsageData', 'getVaccinationUsageData')
                            ->name('dashboard.vaccination_usage_data');
                    });
            });
    });
