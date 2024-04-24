<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\GenericModelTestCase;

class RoleTest extends GenericModelTestCase
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
        $role = Role::factory()->make();
        Account::factory()->make([
            'role_id' => $role->id,
        ]);

        $this->assertInstanceOf(HasMany::class, $role->accounts());
    }
}
