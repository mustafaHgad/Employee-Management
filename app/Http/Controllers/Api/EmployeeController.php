<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService
    ) {}

    public function index(Request $request)
    {
        $employees = $this->employeeService->listEmployees($request);

        return EmployeeResource::collection($employees)->additional([
            'meta' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ]
        ]);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = $this->employeeService->createEmployee($request->validated(),auth()->id());
        return new EmployeeResource($employee);
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee->load('department'));
    }

    public function update( $id,UpdateEmployeeRequest $request)
    {
        $employee = $this->employeeService->updateEmployee($id,$request->validated());
        return new EmployeeResource($employee);
    }

    public function destroy($id)
    {
        $this->employeeService->deleteEmployee($id, auth()->id());
        return response()->json(null, 204);
    }

    public function exportCsv(Request $request)
    {
        return $this->employeeService->exportCsv($request,auth()->id());
    }

    public function exportPdf(Request $request)
    {
        return $this->employeeService->exportPdf($request,auth()->id());
    }
}
