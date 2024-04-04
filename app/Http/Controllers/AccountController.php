<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AccountRequest;
use App\Http\Requests\Auth\PasswordRequest;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function updateBusinessAccount(AccountRequest $request)
    {
        $request->validated();

        $verifyCurrentPassword = Hash::check($request->password_confirmation, auth()->user()->password);

        if (!$verifyCurrentPassword) {
            return redirect()->back()->withErrors(['msg' => 'Your current password is incorrect!']);
        }

        $email = Account::where('email', $request->email)
            ->where('id', '!=', $request->id)
            ->first();

        if (isset($email)) {
            return redirect()->back()->withErrors(['msg' => 'Email has been used by another account!']);
        }

        $account = Account::findOrFail($request->id);
        $account->email = $request->email;
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
