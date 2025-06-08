<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Http\Requests\PermissionRequest\StorePermissionRequest;
use App\Http\Requests\PermissionRequest\UpdatePermissionRequest;

class PermissionController extends Controller {
    protected $permissionService;

    public function __construct(PermissionService $permissionService) {
        $this->permissionService = $permissionService;
    }

    public function index() {
        return view('permissions.index', ['permissions' => $this->permissionService->getAllPermissions()]);
    }

    public function store(StorePermissionRequest $request) {
        $this->permissionService->createPermission($request->validated());
        return redirect()->back();
    }
    
    public function destroy($id) {
        $this->permissionService->deletePermission($id);
        return redirect()->back()->with('success', 'Permission Berhasil Dihapus');
    }
    

    public function update(UpdatePermissionRequest $request, $id) {
        $this->permissionService->updatePermission($id, $request->validated());
        return redirect()->back()->with('success', 'Data Permission Berhasil Diubah');
    }
}

