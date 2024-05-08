<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class RoleTest extends GenericModelTestCase
{
    protected $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = new Role();
    }

    protected function tearDown(): void
    {
        unset($this->role);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->testConfigurations(
            Role::class,
            [],
            ['id'],
            [],
            [],
            ['id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'roles',
            'id',
        );
    }

    public function testRelationships()
    {
        $this->role = Role::factory()->make();

        $this->assertInstanceOf(HasMany::class, $this->role->accounts());
    }
}
