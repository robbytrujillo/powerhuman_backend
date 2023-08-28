<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // powerhuman.com/apy/company?id=1
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);

        if ($id) {
            $company = Company::find($id);
        }
    }
}
