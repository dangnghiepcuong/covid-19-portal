<?php

namespace Tests\Unit\Models;

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

    public function testModelConfiguration()
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
            'id'
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
        $this->assertEquals(
            'select * from `accounts` where `role_id` = ? and `accounts`.`deleted_at` is null',
            Account::isAdmin()->toSql()
        );
    }
}
