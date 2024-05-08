<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\Unit\GenericModelTestCase;

class AccountTest extends GenericModelTestCase
{
    protected $account;

    protected function setUp(): void
    {
        parent::setUp();
        $this->account = new Account();
    }

    protected function tearDown(): void
    {
        unset($this->account);
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
        $this->assertInstanceOf(BelongsTo::class, $this->account->role());
        $this->assertEquals('role_id', $this->account->role()->getForeignKeyName());

        $this->assertInstanceOf(HasOne::class, $this->account->user());
        $this->assertInstanceOf(HasOne::class, $this->account->business());
    }

    public function testSetEmailAttribute()
    {
        $this->account->setEmailAttribute('TesT@example.com');

        $this->assertEquals('test@example.com', $this->account->email);
    }

    public function testScopeIsAdmin()
    {
        $this->assertEquals(
            'select * from `accounts` where `role_id` = ? and `accounts`.`deleted_at` is null',
            Account::isAdmin()->toSql()
        );
    }
}
