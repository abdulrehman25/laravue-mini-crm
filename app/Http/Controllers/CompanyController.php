<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Traits\HelperFunctions;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{UpdateCompanyRequest, StoreCompanyRequest};

class CompanyController extends Controller
{
    use HelperFunctions;

    const LOGO_STORE_PATH = 'media-uploads/company';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Company/Index', [
            'companies' => CompanyResource::collection(Company::paginate(10))->response()->getData(true),
        ]);
    }

    /**
     * Create Method for Company.
     */
    public function create()
    {
        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'website' => $request->validated('website')
        ];
        if ($request->hasFile('logo')) {
            $company['logo'] = Storage::disk('public')->putFile(self::LOGO_STORE_PATH, $request->file('logo'));
        }
        Company::create($company);
        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return CompanyResource::make($company);
    }

    /**
     * Edit Method for Company View.
     */
    public function edit(Company $company)
    {
        return Inertia::render('Company/Create', ['company' => $company, 'update' => true]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $companyData = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'website' => $request->validated('website')
        ];
        if ($request->hasFile('logo')) {
            self::deleteFile($company->logo);
            $companyData['logo'] = Storage::disk('public')->putFile(self::LOGO_STORE_PATH, $request->file('logo'));
        }
        $company->update($companyData);
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $file_path = $company->logo;
        if ($company->delete()) {
            self::deleteFile($file_path);
            return redirect()->route('company.index')->with('success', 'Company deleted successfully');
        }
        return redirect()->route('company.index')->with('error', 'Something went wrong');
    }

}
