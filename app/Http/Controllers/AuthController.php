<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Services\AuthService;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService, $roleService;

    public function __construct(AuthService $authService, RoleService $roleService)
    {
        $this->authService = $authService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (Auth::guard('web')->attempt($request->credentials())) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->with('loginError', 'Password does not match with the provided email');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended(route('dashboard'));
    }

    public function register()
    {
        $roles = $this->roleService->getAllRoles();
        return view('auth.register', ['roles' => $roles]);
    }

    public function store(RegisterRequest $request)
    {
        $this->authService->register($request->validated());
        return redirect()->back()->with('success', 'User Berhasil Didaftarkan');
    }

}
