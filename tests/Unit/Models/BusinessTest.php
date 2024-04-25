<?php

namespace Tests\Unit\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class BusinessTest extends GenericModelTestCase
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
            Business::class,
            [],
            ['id'],
            [],
            [],
            ['id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'businesses',
            'id',
        );
    }

    public function testRelationships()
    {
        $business = new Business();

        $this->assertInstanceOf(BelongsTo::class, $business->account());
        $this->assertEquals('account_id', $business->account()->getForeignKeyName());

        $this->assertInstanceOf(HasMany::class, $business->vaccineLots());
        $this->assertInstanceOf(HasMany::class, $business->schedules());
    }
}
