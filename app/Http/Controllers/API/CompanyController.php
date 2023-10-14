<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
   
    public function fetch(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $companyQuery = Company::with(['users'])->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
            });

         // powerhuman.com/apy/company?id=1
        if ($id) { // get single data
            $company = $companyQuery->find($id);

            if ($company) {
                return ResponseFormatter::success($company, 'Company found');
            }

            return ResponseFormatter::error('Company not found', 404);
        }
        // powerhuman.com/api/company
        //$companies = Company::with(['users']);
        $companies = $companyQuery;// get multiple data
        // $companies = Company::with(['users'])->whereHas('users', function ($query) { // get multiple data
        //     $query -> where('user_id', Auth::id());
        // });

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
        try {
            // Upload logo
            if ($request->hasfile('logo')) {
                $path = $request->file('logo')->store('public/logos');
            }
    
            $company = Company::create([
                'name' => $request->name,
                'logo' => $path,
            ]);

            if (!$company) {
                throw new Exception('Company not created');
            }

            // Attach company to user
            $user = User::find(Auth::id());
            $user->companies()->attach($company->id);

            // Load users at company
            $company -> load('users');
    
            return ResponseFormatter::success($company, 'Company created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }

        
    }

    public function update(UpdateCompanyRequest $request, $id) {
        //return $id;
        //dd($request->all());
        try {
            // Get company
            $company = Company::find($id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            // return $request->file('logo');

            // Upload logo
            if ($request->hasfile('logo')) {
                $path = $request->file('logo')->store('public/logos');
            }

            // Update company
            $company->updated([
                'name' => $request->name,
                'logo' => $path
            ]);

            return ResponseFormatter::success($company, 'Company Updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
