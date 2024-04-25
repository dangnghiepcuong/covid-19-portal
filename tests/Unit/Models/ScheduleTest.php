<?php

namespace Tests\Unit\Models;

use App\Enums\Shift;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class ScheduleTest extends GenericModelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
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
        $schedule = new Schedule();

        $this->assertInstanceOf(BelongsTo::class, $schedule->business());
        $this->assertEquals('business_id', $schedule->business()->getForeignKeyName());

        $this->assertInstanceOf(BelongsTo::class, $schedule->vaccineLot());
        $this->assertEquals('vaccine_lot_id', $schedule->vaccineLot()->getForeignKeyName());

        $this->assertInstanceOf(BelongsToMany::class, $schedule->users());
        $this->assertEquals('user_id', $schedule->users()->getRelatedPivotKeyName());
        $this->assertEquals('schedule_id', $schedule->users()->getForeignPivotKeyName());

        $this->assertInstanceOf(HasMany::class, $schedule->vaccinations());
    }

    public function testGetDayShiftAttribute()
    {
        $schedule = new Schedule();

        $this->assertEquals(
            "{$schedule->day_shift_registration} / {$schedule->day_shift_limit}",
            $schedule->day_shift
        );
    }

    public function testGetNoonShiftAttribute()
    {
        $schedule = new Schedule();

        $this->assertEquals(
            "{$schedule->noon_shift_registration} / {$schedule->noon_shift_limit}",
            $schedule->noon_shift
        );
    }

    public function testGetNightShiftAttribute()
    {
        $schedule = new Schedule();

        $this->assertEquals(
            "{$schedule->night_shift_registration} / {$schedule->night_shift_limit}",
            $schedule->night_shift
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
        $schedule = new Schedule();

        $schedule->day_shift_registration = 1;
        $schedule->noon_shift_registration = 2;
        $schedule->night_shift_registration = 3;

        $schedule->decreaseRegistration(Shift::DAY_SHIFT);
        $schedule->decreaseRegistration(Shift::NOON_SHIFT);
        $schedule->decreaseRegistration(Shift::NIGHT_SHIFT);

        $this->assertEquals(0, $schedule->day_shift_registration);
        $this->assertEquals(1, $schedule->noon_shift_registration);
        $this->assertEquals(2, $schedule->night_shift_registration);
    }
}
