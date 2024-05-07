<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\Unit\GenericModelTestCase;

class UserTest extends GenericModelTestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown(): void
    {
        unset($this->user);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->testConfigurations(
            User::class,
            [],
            ['id'],
            [],
            [],
            ['id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'users',
            'id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->user->account());
        $this->assertEquals('account_id', $this->user->account()->getForeignKeyName());

        $this->assertInstanceOf(BelongsToMany::class, $this->user->schedules());
        $this->assertEquals('schedule_id', $this->user->schedules()->getRelatedPivotKeyName());
        $this->assertEquals('user_id', $this->user->schedules()->getForeignPivotKeyName());
    }

    public function testGetFullNameAttribute()
    {
        $this->assertEquals("{$this->user->last_name} {$this->user->first_name}", $this->user->fullName);
    }
}
