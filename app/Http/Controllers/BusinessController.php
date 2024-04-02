<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\BusinessRequest;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Http\Request;
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
    public function store(BusinessRequest $request)
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
        $account = $business->account()->first();
        $vaccineLots = $business->vaccineLots()->get();

        return view('business.show', ['account' => $account, 'business' => $business, 'vaccine_lots' => $vaccineLots]);
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
        //
    }
}
