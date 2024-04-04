<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Auth\Requests\BusinessCreateRequest;
use App\Http\Requests\BusinessRequest;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businesses = Business::all();

        return view('business.index', ['businesses' => $businesses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('business.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessCreateRequest $request)
    {
        $request->validated();

        DB::transaction(function () use ($request) {
            Account::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => Role::ROLE_BUSINESS,
            ]);

            $accountId = Account::where('email', $request->email)->first()->id;
            Business::create([
                'account_id' => $accountId,
                'name' => $request->name,
                'tax_id' => $request->tax_id,
                'addr_province' => $request->addr_province,
                'addr_district' => $request->addr_district,
                'addr_ward' => $request->addr_ward,
                'address' => $request->address,
                'contact' => $request->contact,
            ]);
        });

        return redirect()->back()->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business = Business::findOrFail($id);
        $account = $business->account()->select('email')->first();
        $vaccineLots = $business->vaccineLots()->get();

        return view('business.show', [
            'account' => $account,
            'business' => $business,
            'vaccineLots' => $vaccineLots,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $business = $account->business()->first();

        return view('business.edit', [
            'account' => $account,
            'business' => $business,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessRequest $request, $id)
    {
        $request->validated();

        $business = Business::findOrFail($id);
        $business->tax_id = $request->tax_id;
        $business->name = $request->name;
        $business->addr_province = $request->addr_province;
        $business->addr_district = $request->addr_district;
        $business->addr_ward = $request->addr_ward;
        $business->address = $request->address;
        $business->contact = $request->contact;

        $business->save();

        return redirect()->back()->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
