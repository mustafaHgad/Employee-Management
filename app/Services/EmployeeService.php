<?php

namespace App\Services;

use App\Repositories\Contracts\EmployeeRepoInterface;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Trait\EmployeePdfTemplate;
class EmployeeService
{
    use EmployeePdfTemplate;
    public function __construct(protected EmployeeRepoInterface $employeeRepo, protected ActivityService $activityLogger) {}

    public function listEmployees($data, int $perPage = 10)
    {
        return $this->employeeRepo->paginateWithDepartment($perPage, $data['department_id']);
    }

    public function createEmployee($data,$userId)
    {
        $employee = $this->employeeRepo->create($data);

        $this->activityLogger->log('employee_created',$userId,"Employee '{$employee->name}' created (id: {$employee->id})");

        return $employee->load('department');
    }

    public function updateEmployee(int $id, array $data, ?int $userId = null)
    {
        $employee = $this->employeeRepo->firstOr($id);

        $this->employeeRepo->update($id, $data);

        $this->activityLogger->log('employee_updated',$userId,"Employee '{$employee->name}' updated (id: {$employee->id})");

        return $employee->fresh('department');
    }

    public function deleteEmployee($id, ?int $userId = null): bool
    {
        $employee = $this->employeeRepo->firstOr($id);
        $this->employeeRepo->delete($employee->id);
        $this->activityLogger->log('employee_deleted',$userId,"Employee '{$employee->name}' deleted (id: {$employee->id})");

        return true;
    }

    public function exportCsv($data, ?int $userId = null): StreamedResponse
    {
        $employees = $this->employeeRepo->allWithDepartment($data['department_id']);
        $filename = 'employees_' . Carbon::now()->format('Ymd_His') . '.csv';


        $this->activityLogger->log('export_csv',$userId,"Exported {$employees->count()} employees to CSV");

        $columns = ['Name', 'Email', 'Salary', 'Department'];

        $callback = function () use ($employees, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($employees as $emp) {
                fputcsv($file, [
                    $emp->name,
                    $emp->email,
                    number_format($emp->salary, 2, '.', ''),
                    $emp->department->name ?? '',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportPdf($data, ?int $userId = null)
    {
        $employees = $this->employeeRepo->allWithDepartment($data['department_id'] ?? null);

        // logging
        $this->activityLogger->log('export_pdf', $userId, "Exported {$employees->count()} employees to PDF");

        // build HTML from Trait
        $html = $this->buildEmployeeHtml($employees);

        // generate PDF
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
        $filename = 'employees_' . Carbon::now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);

    }
}
