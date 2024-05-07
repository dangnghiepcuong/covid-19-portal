<?php

namespace Tests\Unit\Models;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class VaccineTest extends GenericModelTestCase
{
    protected $vaccine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vaccine = new Vaccine();
    }

    protected function tearDown(): void
    {
        unset($this->vaccine);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->testConfigurations(
            Vaccine::class,
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
            'vaccines',
            'id'
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(HasMany::class, $this->vaccine->vaccineLots());
    }

    public function testGetIsAllowAttribute()
    {
        $this->vaccine->is_allow = true;
        $this->assertEquals('Allow', $this->vaccine->is_allow);

        $this->vaccine->is_allow = false;
        $this->assertEquals('Not allow', $this->vaccine->is_allow);
    }

    public function testScopeIsAllow()
    {
        $this->assertEquals(
            'select * from `vaccines` where `is_allow` = ? and `vaccines`.`deleted_at` is null',
            Vaccine::isAllow()->toSql()
        );
    }
}
