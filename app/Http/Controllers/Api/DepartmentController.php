<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function __construct(protected DepartmentService $departServ) {}
    public function index()
    {
        return DepartmentResource::collection($this->departServ->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|unique:departments,name']);

        $department = $this->departServ->create($data, $request->user()->id ?? null);

        return new DepartmentResource($department);
    }

    public function show($id)
    {
        $department = $this->departServ->view($id);

        return new DepartmentResource($department);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate(['name' => "required|string|unique:departments,name,{$id}"]);

        $department = $this->departServ->update($id, $data, $request->user()->id ?? null);

        return new DepartmentResource($department);
    }

    public function destroy(Request $request, $id)
    {
        $this->departServ->delete($id, auth()->id());
        return response()->json(null, 204);
    }
}
