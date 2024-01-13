<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function socialLogin(string $provider): Response
    {
        $redirectUrl = Socialite::driver($provider)->redirect()->getTargetUrl();

        return response('', 409)->header('X-Inertia-Location', $redirectUrl);
    }

    public function handleProviderCallback(string $provider): View|RedirectResponse
    {
        try {
            $user = Socialite::driver($provider)->user();

            $current_user = User::where($provider.'_id', $user->id)->first();

            if ($current_user) {
                Auth::login($current_user);

                return redirect()->intended('dashboard');
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'user_name' => $user->name,
                    $provider.'_id' => $user->id,
                    'password' => Str::password(),
                ]);

                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
