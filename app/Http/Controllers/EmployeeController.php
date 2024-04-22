<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create([
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'company_id' => $request->validated('company_id'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone')
        ]);
        $employee->load(['company:id,name']);
        return EmployeeResource::make($employee);
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
        return EmployeeResource::make($employee->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->delete()) {
            return Response::noContent();
        }
        return Response::json('Something went wrong!', 500);
    }
}
