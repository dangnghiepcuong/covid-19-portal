<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AccountRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\PasswordRequest;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function updateAccount(AccountRequest $request)
    {
        $request->validated();

        $verifyCurrentPassword = Hash::check($request->password_confirmation, Auth::user()->password);
        if (!$verifyCurrentPassword) {
            return redirect()->back()->withErrors(['msg' => __('auth.password')]);
        }

        $email = Account::where('email', $request->email)
            ->where('id', '!=', Auth::user()->id)
            ->first();
        if (isset($email)) {
            return redirect()->back()->withErrors(['msg' => __('auth.email')]);
        }

        $account = Account::findOrFail(Auth::user()->id);
        $account->email = $request->email;
        $account->save();

        return redirect()->back()->with('success', true);
    }

    public function updateBusinessAccount(AccountRequest $request)
    {
        $request->validated();

        $verifyCurrentPassword = Hash::check($request->password_confirmation, Auth::user()->password);
        if (!$verifyCurrentPassword) {
            return redirect()->back()->withErrors(['msg' => __('auth.password')]);
        }

        $email = Account::where('email', $request->email)
            ->where('id', '!=', $request->id)
            ->first();
        if (isset($email)) {
            return redirect()->back()->withErrors(['msg' => __('auth.email')]);
        }

        $account = Account::findOrFail($request->id);
        $account->email = $request->email;
        $account->save();

        return redirect()->back()->with('success', true);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->validated();

        $verifyCurrentPassword = Hash::check($request->current_password, Auth::user()->password);
        if (!$verifyCurrentPassword) {
            return redirect()->back()->withErrors(['msg' => __('auth.password')]);
        }

        $account = Account::findOrFail(Auth::user()->id);
        $account->password = Hash::make($request->password);
        $account->save();

        return redirect()->back()->with('success', true);
    }

    public function resetBusinessPassword(PasswordRequest $request)
    {
        $request->validated();

        $account = Account::findOrFail($request->id);
        $account->password = Hash::make($request->password);
        $account->save();

        return redirect()->back()->with('success', true);
    }
}
