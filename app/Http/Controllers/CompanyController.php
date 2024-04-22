<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CompanyController extends Controller
{
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
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'website' => $request->validated('website')
        ];
        if ($request->has('logo')) {
            $company['logo'] = Storage::disk('public')->putFile(self::LOGO_STORE_PATH, $request->file('logo'));
        }
        $company = Company::create($company);
        return CompanyResource::make($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return CompanyResource::make($company);
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
        if ($request->has('logo')) {
            $companyData['logo'] = Storage::disk('public')->putFile(self::LOGO_STORE_PATH, $request->file('logo'));
        }
        $company->update($companyData);
        return CompanyResource::make($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if ($company->delete()) {
            return Response::noContent();
        }
        return Response::json('Something went wrong!', 500);
    }
}
