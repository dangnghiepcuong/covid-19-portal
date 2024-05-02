<?php

namespace Tests\Unit\Http\Controllers;

use App\Enums\ActionStatus;
use App\Enums\Role as RoleEnum;
use App\Http\Controllers\ScheduleController;
use App\Http\Requests\ScheduleRequest;
use App\Models\Account;
use App\Models\Business;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Vaccine;
use App\Models\VaccineLot;
use App\Repositories\Schedule\ScheduleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    protected $controller;
    protected $mockScheduleRepo;
    protected $mockBusiness;
    protected $mockVaccine;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockScheduleRepo = Mockery::mock(ScheduleRepository::class);
        $this->app->instance('\App\Repositories\Schedule\ScheduleRepository', $this->mockScheduleRepo);
        $this->controller = new ScheduleController($this->mockScheduleRepo);
    }

    public function tearDown(): void
    {
        unset($this->controller);
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_function_return_view()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);

        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('getSchedulesOfABusiness')
            ->andReturn([]);

        $request = Request::create(route('schedules.index', []));

        $response = $this->controller->index($request);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_create_function_return_view()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);

        $this->actingAs($account);

        $response = $this->controller->create();

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_store_function()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);

        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $vaccineLot->setRelation('vaccine', $vaccine);

        $this->actingAs($account);

        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $vaccineLot->id,
            'on_date' => now(),
            'day_shift_limit' => 100,
            'noon_shift_limit' => 100,
            'night_shift_limit' => 100,
        ]);

        $this->mockScheduleRepo->shouldReceive('storeSchedule')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->store($scheduleRequest);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_show_function()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);
        $schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_lot_id' => $vaccineLot->id,
        ]);

        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $vaccineLot->setRelation('vaccine', $vaccine);
        $schedule->setRelation('vaccineLot', $vaccineLot);

        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('findOrFail')
            ->with($schedule->id)
            ->andReturn([]);

        $this->mockScheduleRepo->shouldReceive('getRegistrations')
            ->andReturn([]);

        $request = new Request();

        $response = $this->controller->show($request, $schedule->id);
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_edit_function_return_view()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);
        $schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_lot_id' => $vaccineLot->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $vaccineLot->setRelation('vaccine', $vaccine);
        $schedule->setRelation('business', $business);
        $schedule->setRelation('vaccineLot', $vaccineLot);

        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('findOrFail')
            ->andReturn($schedule);

        $response = $this->controller->edit($schedule->id);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_update_function()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);
        $schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_lot_id' => $vaccineLot->id,
        ]);

        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $vaccineLot->setRelation('vaccine', $vaccine);
        $schedule->setRelation('business', $business);
        $schedule->setRelation('vaccineLot', $vaccineLot);

        $this->actingAs($account);

        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $vaccineLot->id,
            'on_date' => $schedule->on_date,
            'day_shift_limit' => $schedule->day_shift_limit,
            'noon_shift_limit' => $schedule->noon_shift_limit,
            'night_shift_limit' => $schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('updateSchedule')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->update($scheduleRequest, $schedule->id);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_destroy_function()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);
        $schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_lot_id' => $vaccineLot->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $vaccineLot->setRelation('vaccine', $vaccine);
        $schedule->setRelation('business', $business);
        $schedule->setRelation('vaccineLot', $vaccineLot);

        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('destroySchedule')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->destroy($business->id, $schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_trashed_function_return_view()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);

        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('getTrashed')
            ->andReturn([]);

        $request = Request::create(route('schedules.trashed', []));

        $response = $this->controller->trashed($request);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_restore_function()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);
        $schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_lot_id' => $vaccineLot->id,
            'deleted_at' => now(),
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('restore')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->restore($schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_delete_function()
    {
        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->make([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
        ]);
        $schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $business->id,
            'vaccine_lot_id' => $vaccineLot->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);
        $vaccineLot->setRelation('vaccine', $vaccine);
        $schedule->setRelation('business', $business);
        $schedule->setRelation('vaccineLot', $vaccineLot);

        $this->actingAs($account);

        $this->mockScheduleRepo->shouldReceive('forceDelete')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->delete($schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
