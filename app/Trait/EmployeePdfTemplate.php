<?php

namespace App\Trait;

use Illuminate\Support\Collection;
use Carbon\Carbon;

trait EmployeePdfTemplate
{
    public function buildEmployeeHtml(Collection $employees): string
    {
        $date = Carbon::now()->format('Y-m-d H:i');

        $rows = '';
        foreach ($employees as $employe) {
            $rows .= "<tr>
                <td>{$employe->id}</td>
                <td>{$employe->name}</td>
                <td>{$employe->email}</td>
                <td style='text-align:right;'>{$employe->salary}</td>
                <td>{$employe->department->name}</td>
            </tr>";
        }

        return "
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <style>
                body { font-family: DejaVu Sans, Helvetica, sans-serif; font-size:12px; }
                table { width:100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; }
                th { background: #f4f4f4; text-align:left; }
                td { vertical-align: top; }
                .right { text-align: right; }
            </style>
        </head>
        <body>
            <h3>Employees Export</h3>
            <p>Exported at: {$date}</p>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th style='text-align:right;'>Salary</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    {$rows}
                </tbody>
            </table>
        </body>
        </html>";
    }
}
