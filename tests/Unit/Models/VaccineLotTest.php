<?php

namespace Tests\Unit\Models;

use App\Models\VaccineLot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class VaccineLotTest extends GenericModelTestCase
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
            VaccineLot::class,
            [],
            ['id'],
            [],
            [],
            ['id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'vaccine_lots',
            'id',
        );
    }

    public function testRelationships()
    {
        $vaccineLot = VaccineLot::factory()->make();

        $this->assertInstanceOf(BelongsTo::class, $vaccineLot->vaccine());
        $this->assertEquals('vaccine_id', $vaccineLot->vaccine()->getForeignKeyName());

        $this->assertInstanceOf(BelongsTo::class, $vaccineLot->business());
        $this->assertEquals('business_id', $vaccineLot->business()->getForeignKeyName());

        $this->assertInstanceOf(HasMany::class, $vaccineLot->schedules());
    }

    public function testSetExpiryDateAttribute()
    {
        $vaccineLot = VaccineLot::factory()->make([
            'import_date' => '2024-07-03',
            'expiry_date' => 10,
        ]);

        $this->assertEquals('2024-07-13', $vaccineLot->expiry_date);
    }

    public function testGetDteAttribute()
    {
        $vaccineLot = VaccineLot::factory()->make([
            'import_date' => '2024-07-03',
            'expiry_date' => 10,
        ]);

        $this->assertEquals(10, $vaccineLot->dte);
    }

    public function testScopeInStock()
    {
        $this->assertEquals(
            'select * from `vaccine_lots` ' .
            'where `quantity` > ? and `expiry_date` > ? and `vaccine_lots`.`deleted_at` is null',
            VaccineLot::inStock()->toSql()
        );
    }
}
