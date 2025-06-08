<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPosyanduRequest\StoreUserPosyanduRequest;
use App\Http\Requests\UserPosyanduRequest\UpdateUserPosyanduRequest;
use App\Services\UserPosyanduService;
use App\Services\UserService;

class UserPosyanduController extends Controller
{
    protected $userPosyanduService;
    protected $userService;

    public function __construct(UserPosyanduService $userPosyanduService, UserService $userService)
    {
        $this->userPosyanduService = $userPosyanduService;
        $this->userService = $userService;
    }

    public function store(StoreUserPosyanduRequest $request)
    {
        $data = $request->validated();
        $this->userPosyanduService->createUserWithPosyandu($data);

        return redirect()->back()->with('success', 'User Berhasil Ditambahkan');
    }

    public function update(UpdateUserPosyanduRequest $request, $id)
    {
       $this->userPosyanduService->updateUserWithPosyandu($request->validated(),$id);

        return redirect()->back()->with([
            'success' => 'Data User Berhasil Diubah',
        ]);
    }

    public function destroy($id)
    {
        $this->userPosyanduService->deleteUserWithPosyandu($id);

        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }

    public function toggleActive($id)
    {
        $this->userService->toggleUserActive($id);
        return redirect()->back()->with('success', 'Status User Posyandu Berhasil Diubah');
    }

}
