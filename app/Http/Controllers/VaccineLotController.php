<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineLotRequest;
use App\Models\Account;
use App\Models\Vaccine;
use App\Models\VaccineLot;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $vaccines = Vaccine::isAllow()->get();

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
        DB::beginTransaction();
        try {
            $request->validated();
            $business = Auth::user()->business;

            VaccineLot::create([
                'vaccine_id' => $request->vaccine_id,
                'lot' => $request->lot,
                'business_id' => $business->id,
                'quantity' => $request->quantity,
                'import_date' => $request->import_date,
                'expiry_date' => $request->dte,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['msg' => __('message.failed')]);
        }

        DB::commit();

        return redirect()->back()->with([
            'success' => true,
            'action' => __('btn.store'),
        ]);
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
        $vaccines = Vaccine::isAllow()->get();
        $vaccineLot = VaccineLot::findOrFail($id);

        return view('vaccine-lot.edit', [
            'vaccineLot' => $vaccineLot,
            'vaccines' => $vaccines,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VaccineLotRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validated();

            VaccineLot::findOrFail($id)
                ->update([
                    'lot' => $request->lot,
                    'quantity' => $request->quantity,
                    'import_date' => $request->import_date,
                    'expiry_date' => $request->dte,
                ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['msg' => __('message.failed')]);
        }

        DB::commit();

        return redirect()->back()->with([
            'success' => true,
            'action' => __('btn.update'),
        ]);
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

        return redirect()->back()->with([
            'success' => true,
            'action' => __('btn.delete'),
        ]);
    }

    public function trashed()
    {
        $vaccineLots = VaccineLot::onlyTrashed()->get();

        return view('vaccine-lot.trashed', ['vaccineLots' => $vaccineLots]);
    }

    public function restore($id)
    {
        VaccineLot::withTrashed($id)
            ->restore();

        return redirect()->back()->with([
            'success' => true,
            'action' => __('btn.restore'),
        ]);
    }

    public function delete($id)
    {
        $vaccineLot = VaccineLot::onlyTrashed()->findOrFail($id);
        $vaccineLot->forceDelete();

        return redirect()->back()->with([
            'success' => true,
            'action' => __('btn.delete'),
        ]);
    }
}
