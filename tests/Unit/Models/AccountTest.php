<?php

namespace Tests\Unit\Models;

use App\Enums\Role;
use App\Models\Account;
use App\Models\Role as ModelsRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        ModelsRole::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roleSeeder = new RoleSeeder();
        $roleSeeder->run();

        Account::factory()->count(2)->create([
            'role_id' => Role::ROLE_ADMIN,
        ]);

        Account::factory()->count(2)->create([
            'role_id' => Role::ROLE_BUSINESS,
        ]);

        Account::factory()->count(3)->create([
            'role_id' => Role::ROLE_USER,
        ]);

        $countAdmins = Account::isAdmin()->count();
        $this->assertEquals(2, $countAdmins);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        ModelsRole::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
