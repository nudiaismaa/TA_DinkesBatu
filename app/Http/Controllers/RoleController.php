<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use App\Services\PermissionService;
use App\Http\Requests\RoleRequest\StoreRoleRequest;
use App\Http\Requests\RoleRequest\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $roleService;
    protected $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view(
            'roles.index',
            [
                'roles' => $this->roleService->getAllRoles(),
                'permissions' => $this->permissionService->getAllPermissions()
            ]
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->createRole($request->validated());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->back()->with('success', 'Role Berhasil Dihapus');
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->roleService->getRoleById($id);
    
        // Revoke all permissions and update with the selected ones
        $permissions = $request->has('permission') ? $request->permission : [];
        $role->syncPermissions($permissions);
    
        return redirect()->back()->with('success', 'Permissions successfully updated for the role.');
    }
    
}
