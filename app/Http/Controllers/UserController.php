<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Services\RoleService;

class UserController extends Controller
{
    protected $userService, $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('users.index', ['users' => $this->userService->getAllUsers(), 'roles' => $roles]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->validated());
        return redirect()->back()->with('success', 'User Berhasil Ditambahkan');
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->validated());

        $userRoles = $user->roles->pluck('name')->toArray();
        return redirect()->back()->with([
            'success' => 'Data User Berhasil Diubah',
            'userRoles' => $userRoles
        ]);
    }

    public function toggleActive($id)
    {
        $this->userService->toggleUserActive($id);
        return redirect()->back()->with('success', 'Status User Berhasil Diubah');
    }
}
