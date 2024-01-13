<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Display the login view.
     */
    public function showLoginForm(): Response
    {
        return $this->authService->showLoginForm();
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authService->normalLogin($request);
    }

    /**
     * Display the registration view.
     */
    public function showRegisterForm(): Response
    {
        return $this->authService->showRegisterForm();
    }

    /*
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function register(RegisterRequest $request): RedirectResponse
    {
        return $this->authService->register($request->validated());
    }

    /*
    * Display the terms of use view.
    */
    public function useTerms(): Response
    {
        return $this->authService->useTerms();
    }

    /*
    * Display the privacy & policies view.
    */
    public function policy(): Response
    {
        return $this->authService->policy();
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        return $this->authService->logout($request);
    }
}
