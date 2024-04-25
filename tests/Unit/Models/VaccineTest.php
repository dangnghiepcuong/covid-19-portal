<?php

namespace Tests\Unit\Models;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class VaccineTest extends GenericModelTestCase
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
        $vaccine = Vaccine::factory()->make();

        $this->assertInstanceOf(HasMany::class, $vaccine->vaccineLots());
    }

    public function testGetIsAllowAttribute()
    {
        $vaccine = Vaccine::factory()->make([
            'is_allow' => true,
        ]);

        $this->assertEquals('Allow', $vaccine->is_allow);

        $vaccine = Vaccine::factory()->make([
            'is_allow' => false,
        ]);

        $this->assertEquals('Not allow', $vaccine->is_allow);
    }

    public function testScopeIsAllow()
    {
        $this->assertEquals(
            'select * from `vaccines` where `is_allow` = ? and `vaccines`.`deleted_at` is null',
            Vaccine::isAllow()->toSql()
        );
    }
}
