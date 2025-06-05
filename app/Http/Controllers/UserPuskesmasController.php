<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPuskesmasRequest\StoreUserPuskesmasRequest;
use App\Http\Requests\UserPuskesmasRequest\UpdateUserPuskesmasRequest;
use App\Services\UserPuskesmasService;
use App\Services\UserService;

class UserPuskesmasController extends Controller
{
    protected $userPuskesmasService;
    protected $userService;

    public function __construct(UserPuskesmasService $userPuskesmasService, UserService $userService)
    {
        $this->userPuskesmasService = $userPuskesmasService;
        $this->userService = $userService;
    }

    public function store(StoreUserPuskesmasRequest $request)
    {
        $data = $request->validated();
        $this->userPuskesmasService->createUserWithPuskesmas($data);

        session()->flash('active_tab', 'akun-puskesmas-tab');

        return redirect()->back()->with('success', 'User Berhasil Ditambahkan');
    }

    public function update(UpdateUserPuskesmasRequest $request, $id)
    {
        $this->userPuskesmasService->updateUserWithPuskesmas($request->validated(), $id);

        return redirect()->back()->with([
            'success' => 'Data User Berhasil Diubah',
        ]);
    }

    public function destroy($id)
    {
        $this->userPuskesmasService->deleteUserWithPuskesmas($id);

        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }

    public function toggleActive($id)
    {
        $this->userService->toggleUserActive($id);
        return redirect()->back()->with('success', 'Status User Puskesmas Berhasil Diubah');
    }
}
