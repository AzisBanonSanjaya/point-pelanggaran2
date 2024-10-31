<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\ForgotPasswordService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    private User $users;
    private ForgotPasswordService $forgotPasswordService;
    public function __construct(User $users, ForgotPasswordService $forgotPasswordService)
    {
        $this->users = $users;
        $this->forgotPasswordService = $forgotPasswordService;
    }



    public function index(): View|Factory
    {
        return view("backEnd.login");
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->with('error', 'Gagal Login!');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function forgotPassword(): View|Factory
    {
        return view("backEnd.forgotPassword.index");
    }


    public function resetPassword(Request $request): View|Factory
    {
        $token = $request->token;
        $email = $request->email;
        return view("backEnd.forgotPassword.form", compact('token','email'));
    }

    public function sendForgotPassword(ForgotPasswordRequest $request): RedirectResponse
    {
        try {
            $users = $this->users->where('email', $request->email)->first();
            return $this->forgotPasswordService->saveToken($request, $users);
        } catch (\Exception $exc) {
            return back()->with('error', 'Gagal Kirim!');
        }
    }
    public function submitResetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        try {
            return $this->forgotPasswordService->saveResetPassword($request);
        } catch (\Exception $exc) {
            return back()->with('error', 'Gagal Kirim!');
        }
    }

}
