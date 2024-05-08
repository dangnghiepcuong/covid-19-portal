<?php

namespace Tests\Unit\Models;

use App\Models\VaccineLot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class VaccineLotTest extends GenericModelTestCase
{
    protected $vaccineLot;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vaccineLot = new VaccineLot();
        $this->vaccineLot->import_date = '2024-07-03';
        $this->vaccineLot->expiry_date = 10;
    }

    protected function tearDown(): void
    {
        unset($this->vaccineLot);
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
        $this->assertInstanceOf(BelongsTo::class, $this->vaccineLot->vaccine());
        $this->assertEquals('vaccine_id', $this->vaccineLot->vaccine()->getForeignKeyName());

        $this->assertInstanceOf(BelongsTo::class, $this->vaccineLot->business());
        $this->assertEquals('business_id', $this->vaccineLot->business()->getForeignKeyName());

        $this->assertInstanceOf(HasMany::class, $this->vaccineLot->schedules());
    }

    public function testSetExpiryDateAttribute()
    {
        $this->assertEquals('2024-07-13', $this->vaccineLot->expiry_date);
    }

    public function testGetDteAttribute()
    {
        $this->assertEquals(10, $this->vaccineLot->dte);
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
