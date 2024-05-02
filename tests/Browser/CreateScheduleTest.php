<?php

namespace Tests\Browser;

use App\Enums\Role as RoleEnum;
use App\Models\Account;
use App\Models\Business;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Vaccine;
use App\Models\VaccineLot;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateScheduleTest extends DuskTestCase
{
    public function test_browse_create_view()
    {
        Browser::macro('typeDate', function ($selector, $year, $month, $day) {
            $this->keys($selector, $day)
                ->keys($selector, $month)
                ->keys($selector, $year);

            return $this;
        });

        $role = Role::factory()->create([
            'id' => RoleEnum::ROLE_BUSINESS,
        ]);
        $account = Account::factory()->create([
            'id' => 1,
            'role_id' => $role->id,
        ]);
        $business = Business::factory()->create([
            'id' => 1,
            'account_id' => $account->id,
        ]);
        $account->setRelation('role', $role);
        $account->setRelation('business', $business);

        $vaccine = Vaccine::factory()->create([
            'is_allow' => true,
        ]);
        $vaccineLot = VaccineLot::factory()->create([
            'business_id' => $business->id,
            'vaccine_id' => $vaccine->id,
            'quantity' => 3000,
        ]);
        $vaccineLot->setRelation('vaccine', $vaccineLot);
        $vaccine->setRelation('business', $business);

        $this->browse(function ($browser) use ($account) {
            $browser->loginAs($account)
                ->visit(route('schedules.create'))
                ->assertSee('Create Schedule')
                ->press('btn-create')
                ->assertSee('The on date must be a date after today.')
                ->typeDate(
                    '#on_date',
                    now()->addDay()->format('Y'),
                    now()->addDay()->format('m'),
                    now()->addDay()->format('d')
                )
                ->type('day_shift_limit', -1)
                ->type('noon_shift_limit', -1)
                ->type('night_shift_limit', -1)
                ->press('btn-create')
                ->assertSee('The day shift limit must be greater than or equal to 0.')
                ->assertSee('The noon shift limit must be greater than or equal to 0.')
                ->assertSee('The night shift limit must be greater than or equal to 0.');
        });

        $this->browse(function ($browser) use ($account, $vaccineLot) {
            $browser->loginAs($account)
                ->visit(route('schedules.create'))
                ->typeDate(
                    '#on_date',
                    now()->addDay()->format('Y'),
                    now()->addDay()->format('m'),
                    now()->addDay()->format('d')
                )
                ->select('vaccine_lot_id', $vaccineLot->id)
                ->type('day_shift_limit', 1000)
                ->type('noon_shift_limit', 1000)
                ->type('night_shift_limit', 1001)
                ->press('btn-create')
                ->assertSee('The total limit must be less than or equal to the vaccine lot quantity');
        });

        $this->browse(function ($browser) use ($account, $vaccineLot) {
            $browser->loginAs($account)
                ->visit(route('schedules.create'))
                ->typeDate(
                    '#on_date',
                    now()->addDay()->format('Y'),
                    now()->addDay()->format('m'),
                    now()->addDay()->format('d')
                )
                ->select('vaccine_lot_id', $vaccineLot->id)
                ->type('day_shift_limit', 1000)
                ->type('noon_shift_limit', 1000)
                ->type('night_shift_limit', 100)
                ->press('btn-create')
                ->assertSee('Create Schedule successfully!');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schedule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $vaccineLot->forceDelete();
        $vaccine->forceDelete();
        $business->forceDelete();
        $account->forceDelete();
        $role->forceDelete();
    }
}
