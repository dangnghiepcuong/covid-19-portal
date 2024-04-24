<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Business;
use App\Models\Role;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roleSeeder = new RoleSeeder();
        $roleSeeder->run();

        $business = Business::factory()->make();

        $this->assertInstanceOf(BelongsTo::class, $business->account());
        $this->assertEquals('account_id', $business->account()->getForeignKeyName());

        $this->assertInstanceOf(HasMany::class, $business->vaccineLots());
        $this->assertInstanceOf(HasMany::class, $business->schedules());

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
