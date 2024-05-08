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
    protected $role;
    protected $account;
    protected $business;
    protected $vaccine;
    protected $vaccineLot;
    protected $schedule;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockScheduleRepo = Mockery::mock(ScheduleRepository::class);
        $this->controller = new ScheduleController($this->mockScheduleRepo);

        $role = Role::factory()->make([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $this->account = Account::factory()->make([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $this->business = Business::factory()->make([
            'id' => 1,
            'account_id' => $this->account->id,
        ]);
        $this->account->setRelation('role', $role);
        $this->account->setRelation('business', $this->business);

        $this->vaccine = Vaccine::factory()->make([
            'id' => 1,
        ]);
        $this->vaccineLot = VaccineLot::factory()->make([
            'id' => 1,
            'business_id' => $this->business->id,
            'vaccine_id' => $this->vaccine->id,
        ]);
        $this->vaccineLot->setRelation('vaccine', $this->vaccine);

        $this->schedule = Schedule::factory()->make([
            'id' => 1,
            'business_id' => $this->business->id,
            'vaccine_lot_id' => $this->vaccineLot->id,
        ]);
        $this->schedule->setRelation('business', $this->business);
        $this->schedule->setRelation('vaccineLot', $this->vaccineLot);

        $this->actingAs($this->account);
    }

    public function tearDown(): void
    {
        unset($this->controller);
        Mockery::close();
        unset($this->role);
        unset($this->account);
        unset($this->business);
        unset($this->vaccine);
        unset($this->vaccineLot);
        unset($this->schedule);
        parent::tearDown();
    }

    public function test_index_function_return_view()
    {
        $this->mockScheduleRepo->shouldReceive('getSchedulesOfABusiness')
            ->andReturn([]);

        $request = Request::create(route('schedules.index', []));

        $response = $this->controller->index($request);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_create_function_return_view()
    {
        $response = $this->controller->create();

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_store_function_return_success()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
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

    public function test_store_function_return_warning()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => now(),
            'day_shift_limit' => 100,
            'noon_shift_limit' => 100,
            'night_shift_limit' => 100,
        ]);

        $this->mockScheduleRepo->shouldReceive('storeSchedule')
            ->andReturn(['status' => ActionStatus::WARNING, 'message' => 'message']);

        $response = $this->controller->store($scheduleRequest);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_store_function_return_error()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => $this->schedule->on_date,
            'day_shift_limit' => $this->schedule->day_shift_limit,
            'noon_shift_limit' => $this->schedule->noon_shift_limit,
            'night_shift_limit' => $this->schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('storeSchedule')
            ->andReturn(['status' => ActionStatus::ERROR, 'message' => 'message']);

        $response = $this->controller->store($scheduleRequest);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_store_function_return_default()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => $this->schedule->on_date,
            'day_shift_limit' => $this->schedule->day_shift_limit,
            'noon_shift_limit' => $this->schedule->noon_shift_limit,
            'night_shift_limit' => $this->schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('storeSchedule')
            ->andReturn(['status' => ActionStatus::allCases(), 'message' => 'message']);

        $response = $this->controller->store($scheduleRequest);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_show_function()
    {
        $this->mockScheduleRepo->shouldReceive('findOrFail')
            ->with($this->schedule->id)
            ->andReturn([]);

        $this->mockScheduleRepo->shouldReceive('getRegistrations')
            ->andReturn([]);

        $request = new Request();

        $response = $this->controller->show($request, $this->schedule->id);
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_edit_function_return_view()
    {
        $this->mockScheduleRepo->shouldReceive('findOrFail')
            ->andReturn($this->schedule);

        $response = $this->controller->edit($this->schedule->id);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_update_function_return_success()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => $this->schedule->on_date,
            'day_shift_limit' => $this->schedule->day_shift_limit,
            'noon_shift_limit' => $this->schedule->noon_shift_limit,
            'night_shift_limit' => $this->schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('updateSchedule')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->update($scheduleRequest, $this->schedule->id);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_update_function_return_warning()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => $this->schedule->on_date,
            'day_shift_limit' => $this->schedule->day_shift_limit,
            'noon_shift_limit' => $this->schedule->noon_shift_limit,
            'night_shift_limit' => $this->schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('updateSchedule')
            ->andReturn(['status' => ActionStatus::WARNING, 'message' => 'message']);

        $response = $this->controller->update($scheduleRequest, $this->schedule->id);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_update_function_return_error()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => $this->schedule->on_date,
            'day_shift_limit' => $this->schedule->day_shift_limit,
            'noon_shift_limit' => $this->schedule->noon_shift_limit,
            'night_shift_limit' => $this->schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('updateSchedule')
            ->andReturn(['status' => ActionStatus::ERROR, 'message' => 'message']);

        $response = $this->controller->update($scheduleRequest, $this->schedule->id);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_update_function_return_default()
    {
        $scheduleRequest = new ScheduleRequest([
            'vaccine_lot_id' => $this->vaccineLot->id,
            'on_date' => $this->schedule->on_date,
            'day_shift_limit' => $this->schedule->day_shift_limit,
            'noon_shift_limit' => $this->schedule->noon_shift_limit,
            'night_shift_limit' => $this->schedule->night_shift_limit,
        ]);

        $this->mockScheduleRepo->shouldReceive('updateSchedule')
            ->andReturn(['status' => ActionStatus::allCases(), 'message' => 'message']);

        $response = $this->controller->update($scheduleRequest, $this->schedule->id);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_destroy_function_return_success()
    {
        $this->mockScheduleRepo->shouldReceive('destroySchedule')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->destroy($this->business->id, $this->schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_destroy_function_return_warning()
    {
        $this->mockScheduleRepo->shouldReceive('destroySchedule')
            ->andReturn(['status' => ActionStatus::WARNING, 'message' => 'message']);

        $response = $this->controller->destroy($this->business->id, $this->schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_destroy_function_return_error()
    {
        $this->mockScheduleRepo->shouldReceive('destroySchedule')
            ->andReturn(['status' => ActionStatus::ERROR, 'message' => 'message']);

        $response = $this->controller->destroy($this->business->id, $this->schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_destroy_function_return_default()
    {
        $this->mockScheduleRepo->shouldReceive('destroySchedule')
            ->andReturn(['status' => ActionStatus::allCases(), 'message' => 'message']);

        $response = $this->controller->destroy($this->business->id, $this->schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_trashed_function_return_view()
    {
        $this->mockScheduleRepo->shouldReceive('getTrashed')
            ->andReturn([]);

        $request = Request::create(route('schedules.trashed', []));

        $response = $this->controller->trashed($request);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_restore_function()
    {
        $this->mockScheduleRepo->shouldReceive('restore')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->restore($this->schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_delete_function()
    {
        $this->mockScheduleRepo->shouldReceive('forceDelete')
            ->andReturn(['status' => ActionStatus::SUCCESS, 'message' => 'message']);

        $response = $this->controller->delete($this->schedule->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
