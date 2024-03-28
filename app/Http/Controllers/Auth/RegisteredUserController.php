<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request)
    {
        $request->validated();

        DB::transaction(function () use ($request) {
            Account::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => Role::ROLE_USER,
            ]);

            $account_id = Account::where('email', $request->email)->first()->id;
            User::create([
                'account_id' => $account_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'pid' => $request->pid,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'addr_province' => $request->addr_province,
                'addr_district' => $request->addr_district,
                'addr_ward' => $request->addr_ward,
                'address' => $request->address,
                'contact' => $request->contact,
            ]);
        });

        $account = Account::where('email', $request->email)->first();

        event(new Registered($account));

        Auth::login($account);

        return redirect(RouteServiceProvider::HOME);
    }
}
