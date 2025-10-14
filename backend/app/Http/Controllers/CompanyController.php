<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::select('id', 'name', 'code')->get();
        
        return response()->json($companies, 200);
    }
}