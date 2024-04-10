<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessSearchRequest;
use App\Models\Vaccine;

class VaccinationController extends Controller
{
    public function index(BusinessSearchRequest $request)
    {
        $request->validated();
        $vaccines = Vaccine::isAllow()->get();

        return view('vaccination.index', ['vaccines' => $vaccines]);
    }
}
