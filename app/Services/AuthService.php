<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Laravel\Socialite\Facades\Socialite;

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

    public function socialLogin(string $provider): Response
    {
        $redirectUrl = Socialite::driver($provider)->redirect()->getTargetUrl();

        return response('', 409)->header('X-Inertia-Location', $redirectUrl);
    }

    public function handleProviderCallback(string $provider): RedirectResponse
    {
        try {
            $user = Socialite::driver($provider)->user();

            $current_user = $this->userRepository->findByField($provider.'_id', $user->id);

            if ($current_user) {
                Auth::login($current_user);

                return redirect()->intended('dashboard');
            } else {
                $newUser = $this->userRepository->updateOrCreate(
                    ['email' => $user->email],
                    [
                        'user_name' => $user->name,
                        $provider.'_id' => $user->id,
                        'password' => Str::password(),
                    ]
                );

                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('login');
        }
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
