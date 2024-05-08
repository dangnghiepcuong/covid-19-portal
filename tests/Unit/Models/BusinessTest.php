<?php

namespace Tests\Unit\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class BusinessTest extends GenericModelTestCase
{
    protected $business;

    protected function setUp(): void
    {
        parent::setUp();
        $this->business = new Business();
    }

    protected function tearDown(): void
    {
        unset($this->business);
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
        $this->business = new Business();

        $this->assertInstanceOf(BelongsTo::class, $this->business->account());
        $this->assertEquals('account_id', $this->business->account()->getForeignKeyName());

        $this->assertInstanceOf(HasMany::class, $this->business->vaccineLots());
        $this->assertInstanceOf(HasMany::class, $this->business->schedules());
    }
}
