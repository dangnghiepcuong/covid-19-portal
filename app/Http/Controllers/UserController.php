<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $account = Account::findOrFail($user->account_id);

        return view('user.show', ['account' => $account, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Account::destroy($user->account_id);

        return back();
    }

    public function profile()
    {
        $user = User::where('account_id', Auth::user()->id)->first();

        return view('user.personal', ['account' => $user->account, 'user' => $user]);
    }

    public function updateProfile(UserRequest $request)
    {
        $request->validated();

        $user = User::findOrFail(Auth::user()->user->id);
        $user->pid = $request->pid;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->addr_province = $request->addr_province;
        $user->addr_district = $request->addr_district;
        $user->addr_ward = $request->addr_ward;
        $user->address = $request->address;
        $user->contact = $request->contact;
        $user->save();

        return redirect()->back()->with('success', true);
    }
}
