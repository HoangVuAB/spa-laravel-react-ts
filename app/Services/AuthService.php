<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class AuthService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function showLoginForm(): InertiaResponse
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function normalLogin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function showRegisterForm(): InertiaResponse
    {
        return Inertia::render('Auth/Register');
    }

    public function register(array $data): RedirectResponse
    {
        $user = $this->userRepository->create(($data));

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function useTerms(): InertiaResponse
    {
        return Inertia::render('TermsOfUse/Index');
    }

    public function policy(): InertiaResponse
    {
        return Inertia::render('PrivacyPolicy/Index');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
