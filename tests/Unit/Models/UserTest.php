<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Tests\Unit\GenericModelTestCase;

class UserTest extends GenericModelTestCase
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roleSeeder = new RoleSeeder();
        $roleSeeder->run();

        $user = User::factory()->make();

        $this->assertInstanceOf(BelongsTo::class, $user->account());
        $this->assertEquals('account_id', $user->account()->getForeignKeyName());

        $this->assertInstanceOf(HasMany::class, $user->forms());

        $this->assertInstanceOf(BelongsToMany::class, $user->schedules());
        $this->assertEquals('schedule_id', $user->schedules()->getRelatedPivotKeyName());
        $this->assertEquals('user_id', $user->schedules()->getForeignPivotKeyName());

        $this->assertInstanceOf(HasMany::class, $user->vaccinations());

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function testGetFullNameAttribute()
    {
        $user = User::factory()->make();

        $this->assertEquals("{$user->last_name} {$user->first_name}", $user->fullName);
    }
}
