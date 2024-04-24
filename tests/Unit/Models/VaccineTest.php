<?php

namespace Tests\Unit\Models;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vaccine::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Vaccine::factory()->count(5)->create([
            'is_allow' => true,
        ]);

        Vaccine::factory()->count(3)->create([
            'is_allow' => false,
        ]);

        $this->assertEquals(5, Vaccine::isAllow()->count());

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vaccine::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
