<?php

namespace App\Http\Controllers;

use App\Enums\ActionStatus;
use App\Http\Requests\VaccineLotRequest;
use App\Models\Vaccine;
use App\Models\VaccineLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VaccineLotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = Auth::user()->business;
        $vaccines = Vaccine::isAllow()->get();
        $vaccineLots = VaccineLot::where('business_id', $business->id);

        if ($request->vaccine_id !== null) {
            $vaccineLots = $vaccineLots->where('vaccine_id', $request->vaccine_id);
        }

        if ($request->quantity !== null) {
            $vaccineLots = $vaccineLots->where('quantity', '>=', $request->quantity);
        }

        if ($request->import_date !== null) {
            $vaccineLots = $vaccineLots->whereDate('import_date', '>=', $request->import_date);
        }

        if ($request->expiry_date !== null) {
            $vaccineLots = $vaccineLots->whereDate('expiry_date', '<=', $request->expiry_date);
        }

        $vaccineLots = $vaccineLots->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));

        return view('vaccine-lot.index', [
            'vaccineLots' => $vaccineLots,
            'vaccines' => $vaccines,
            'attributes' => $request,
        ]);
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

    protected function checkLotNumber(Request $request, $businessId)
    {
        $vaccineLot = VaccineLot::where([
            'business_id' => $businessId,
            'lot' => $request->lot,
        ])->first();

        if ($vaccineLot !== null) {
            return [
                'check' => false,
                'message' => __('vaccine-lot.message.lot_existed'),
            ];
        }

        return [
            'check' => true,
            'message' => __('message.success'),
        ];
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

            $checkLotNumber = $this->checkLotNumber($request, $business->id);
            if ($checkLotNumber['check'] === false) {
                DB::rollBack();

                return redirect()->back()->with(
                    [
                        'status' => ActionStatus::WARNING,
                        'message' => $checkLotNumber['message'],
                    ]
                )->withInput();
            }

            VaccineLot::create([
                'vaccine_id' => $request->vaccine_id,
                'lot' => $request->lot,
                'business_id' => $business->id,
                'quantity' => $request->quantity,
                'import_date' => $request->import_date,
                'expiry_date' => $request->dte,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
                // 'message' => $e->getMessage(),
            ])->withInput();
        }

        DB::commit();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __(
                'message.success',
                [
                    'action' => __('btn.import', [
                        'object' => __('vaccine-lot.vaccine_lot'),
                    ]),
                ],
            ),
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
            $business = Auth::user()->business;

            $checkLotNumber = $this->checkLotNumber($request, $business->id);
            if ($checkLotNumber['check'] === false) {
                DB::rollBack();

                return redirect()->back()->with(
                    [
                        'status' => ActionStatus::WARNING,
                        'message' => $checkLotNumber['message'],
                    ]
                )->withInput();
            }

            $business->vaccineLots()->findOrFail($id)
                ->update([
                    'lot' => $request->lot,
                    'quantity' => $request->quantity,
                    'import_date' => $request->import_date,
                    'expiry_date' => $request->dte,
                ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
                // 'message' => $e->getMessage(),
            ])->withInput();
        }

        DB::commit();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __(
                'message.success',
                [
                    'action' => __('btn.update', [
                        'object' => __('vaccine-lot.vaccine_lot'),
                    ]),
                ],
            ),
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
        $business = Auth::user()->business;
        $business->vaccineLots()->findOrFail($id)->delete();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.delete')]),
        ]);
    }

    public function trashed(Request $request)
    {
        $business = Auth::user()->business;
        $vaccines = Vaccine::isAllow()->get();
        $vaccineLots = $business->vaccineLots()->onlyTrashed();

        if ($request->vaccine_id !== null) {
            $vaccineLots = $vaccineLots->where('vaccine_id', $request->vaccine_id);
        }

        if ($request->quantity !== null) {
            $vaccineLots = $vaccineLots->where('quantity', '>=', $request->quantity);
        }

        if ($request->import_date !== null) {
            $vaccineLots = $vaccineLots->whereDate('import_date', '>=', $request->import_date);
        }

        if ($request->expiry_date !== null) {
            $vaccineLots = $vaccineLots->whereDate('expiry_date', '<=', $request->expiry_date);
        }

        $vaccineLots = $vaccineLots->paginate(config('DEFAULT_PAGINATING_NUMBER'));

        return view('vaccine-lot.trashed', [
            'vaccineLots' => $vaccineLots,
            'vaccines' => $vaccines,
            'attributes' => $request,
        ]);
    }

    public function restore($id)
    {
        $business = Auth::user()->business;
        $business->vaccineLots()->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.restore')]),
        ]);
    }

    public function delete($id)
    {
        $business = Auth::user()->business;
        $business->vaccineLots()->onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.delete')]),
        ]);
    }
}
