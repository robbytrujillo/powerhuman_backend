<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
   
    public function all(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

         // powerhuman.com/apy/company?id=1
        if ($id) {
            $company = Company::with(['users'])->find($id);

            if ($company) {
                return ResponseFormatter::success($company, 'Company found');
            }

            return ResponseFormatter::error('Company not found', 404);
        }
        // powerhuman.com/api/company
        $companies = Company::with(['users']);

        // filtering nama perusahaan  ..... powerhuman.com/apy/company?name=Kunde
        if ($name) {
            $companies ->where ('name', 'like', '%' . $name. '%');
        }

         // Company::with(['users'])->where('name', 'like', '%Kunde%')->paginate(10);
        return ResponseFormatter::success(
            $companies->paginate($limit),
            'Companies found'
        );

       
    }

    public function create(CreateCompanyRequest $request) {
        $company = Company::create([
            'name' => $request->name,
            'name' => $request->name,
            'name' => $request->name,
        ])
    }
}
