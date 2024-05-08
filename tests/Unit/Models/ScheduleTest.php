<?php

namespace Tests\Unit\Models;

use App\Enums\Shift;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\Unit\GenericModelTestCase;

class ScheduleTest extends GenericModelTestCase
{
    protected $schedule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->schedule = new Schedule();
    }

    protected function tearDown(): void
    {
        unset($this->schedule);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->testConfigurations(
            Schedule::class,
            [],
            ['id'],
            [],
            [],
            [
                'deleted_at' => 'datetime',
                'id' => 'int',
            ],
            ['created_at', 'updated_at'],
            null,
            'schedules',
            'id'
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->schedule->business());
        $this->assertEquals('business_id', $this->schedule->business()->getForeignKeyName());

        $this->assertInstanceOf(BelongsTo::class, $this->schedule->vaccineLot());
        $this->assertEquals('vaccine_lot_id', $this->schedule->vaccineLot()->getForeignKeyName());

        $this->assertInstanceOf(BelongsToMany::class, $this->schedule->users());
        $this->assertEquals('user_id', $this->schedule->users()->getRelatedPivotKeyName());
        $this->assertEquals('schedule_id', $this->schedule->users()->getForeignPivotKeyName());
    }

    public function testGetDayShiftAttribute()
    {
        $this->assertEquals(
            "{$this->schedule->day_shift_registration} / {$this->schedule->day_shift_limit}",
            $this->schedule->day_shift
        );
    }

    public function testGetNoonShiftAttribute()
    {
        $this->assertEquals(
            "{$this->schedule->noon_shift_registration} / {$this->schedule->noon_shift_limit}",
            $this->schedule->noon_shift
        );
    }

    public function testGetNightShiftAttribute()
    {
        $this->assertEquals(
            "{$this->schedule->night_shift_registration} / {$this->schedule->night_shift_limit}",
            $this->schedule->night_shift
        );
    }

    public function testScopeIsAvailable()
    {
        $this->assertEquals(
            'select * from `schedules` where `on_date` > ? and `schedules`.`deleted_at` is null',
            Schedule::isAvailable()->toSql()
        );
    }

    public function testDecreaseRegistration()
    {
        $this->schedule->day_shift_registration = 1;
        $this->schedule->noon_shift_registration = 2;
        $this->schedule->night_shift_registration = 3;

        $this->schedule->decreaseRegistration(Shift::DAY_SHIFT);
        $this->schedule->decreaseRegistration(Shift::NOON_SHIFT);
        $this->schedule->decreaseRegistration(Shift::NIGHT_SHIFT);

        $this->assertEquals(0, $this->schedule->day_shift_registration);
        $this->assertEquals(1, $this->schedule->noon_shift_registration);
        $this->assertEquals(2, $this->schedule->night_shift_registration);
        $this->assertEquals(false, $this->schedule->decreaseRegistration(Shift::allCases()));
    }
}
