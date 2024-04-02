<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineLotRequest;
use App\Models\Account;
use App\Models\Vaccine;
use App\Models\VaccineLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaccineLotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = Account::findOrFail(Auth::user()->id);
        $vaccineLots = VaccineLot::where('business_id', $account->business()->first()->id)->get();

        return view('vaccine-lot.index', ['vaccineLots' => $vaccineLots]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vaccines = Vaccine::all();

        return view('vaccine-lot.create', ['vaccines' => $vaccines]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VaccineLotRequest $request)
    {
        $request->validated();

        $expiryDate = date_add(
            date_create($request->import_date),
            date_interval_create_from_date_string($request->dte . ' days')
        );
        $expiryDate = $expiryDate->format('Y-m-d');

        $account = Account::findOrFail(Auth::user()->id);

        VaccineLot::create([
            'vaccine_id' => $request->vaccine_id,
            'lot' => $request->lot,
            'business_id' => $account->business()->first()->id,
            'quantity' => $request->quantity,
            'import_date' => $request->import_date,
            'expiry_date' => $expiryDate,
        ]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vaccineLot = VaccineLot::findOrFail($id);

        return view('vaccine-lot.edit', ['vaccineLot' => $vaccineLot]);
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
        VaccineLot::destroy($id);

        return redirect()->back()->with('success', true);
    }
}
