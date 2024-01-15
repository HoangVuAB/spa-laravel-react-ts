<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class SocialiteController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /*
    * Redirect to login social account
    */
    public function socialLogin(string $provider): Response
    {
        return $this->authService->socialLogin($provider);
    }

    /*
    * Handle callback to provider
    */
    public function handleProviderCallback(string $provider): RedirectResponse
    {
        return $this->authService->handleProviderCallback($provider);
    }
}
