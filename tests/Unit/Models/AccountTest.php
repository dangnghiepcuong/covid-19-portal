<?php

namespace Tests\Unit\Models;

use App\Enums\Role;
use App\Models\Account;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\Unit\GenericModelTestCase;

class AccountTest extends GenericModelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_model_configuration()
    {
        $this->testConfigurations(
            Account::class,
            [],
            [],
            [],
            ['password', 'remember_token'],
            [
                'email_verified_at' => 'datetime',
                'deleted_at' => 'datetime',
                'id' => 'int',
            ],
            ['created_at', 'updated_at'],
            null,
            'accounts',
            'id',
        );
    }

    public function testRelationships()
    {
        $account = Account::factory()->make();

        $this->assertInstanceOf(BelongsTo::class, $account->role());
        $this->assertEquals('role_id', $account->role()->getForeignKeyName());

        $this->assertInstanceOf(HasOne::class, $account->user());
        $this->assertInstanceOf(HasOne::class, $account->business());
    }

    public function testSetEmailAttribute()
    {
        $account = new Account();
        $account->setEmailAttribute('TesT@example.com');

        $this->assertEquals('test@example.com', $account->email);
    }

    public function testScopeIsAdmin()
    {
        Account::factory()->make([
            'role_id' => Role::ROLE_ADMIN,
        ]);

        $countAdmins = Account::isAdmin()->count();
        $this->assertEquals(1, $countAdmins);
    }
}
