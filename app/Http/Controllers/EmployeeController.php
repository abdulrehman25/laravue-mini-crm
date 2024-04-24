<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Employee;
use App\Http\Resources\{CompanyResource, EmployeeResource};
use App\Http\Requests\{UpdateEmployeeRequest, StoreEmployeeRequest};

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('company:id,name')->paginate(10);
        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResource::collection($employees)->response()->getData(true),
        ]);
    }

    /**
     * Create Method for Employee View.
     */
    public function create()
    {
        return Inertia::render('Employee/Create', [
            'companies' => CompanyResource::collection(Company::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create([
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'company_id' => $request->validated('company_id'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone')
        ]);
        return redirect()->route('employee.index')->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['company:id,name']);
        return EmployeeResource::make($employee);
    }

    /**
     * Edit Method for Employee View.
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Employee/Create', [
            'employee' => $employee,
            'companies' => CompanyResource::collection(Company::all()),
            'update' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update([
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'company_id' => $request->validated('company_id'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone')
        ]);
        $employee->load('company:id,name');
        return redirect()->route('employee.index')->with('success', 'Employee update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->delete()) {
            return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
        }
        return redirect()->route('employee.index')->with('error', 'Something went wrong');
    }
}
