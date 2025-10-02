<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    /**
     * Redirect to the OAuth provider.
     */
    public function redirect($provider)
    {
        $driver = Socialite::driver($provider);

        // Force account selection
        if ($provider === 'github') {
            $driver = $driver->with([
                'allow_signup' => 'true',
                'prompt' => 'select_account'
            ]);
        }

        if ($provider === 'google') {
            $driver = $driver->with(['prompt' => 'select_account']);
        }

        return $driver->stateless()->redirect();
    }

    /**
     * Handle callback from OAuth provider.
     */
    public function callback($provider)
    {
        // Get user data from provider
        $socialUser = Socialite::driver($provider)->stateless()->user();

        // Fallback for name
        $name = $socialUser->getName()
            ?? $socialUser->getNickname()
            ?? $socialUser->getEmail()
            ?? 'Unknown User';

        // Check if user already exists by email
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update provider info if user exists
            $user->update([
                'provider_id' => $socialUser->getId(),
                'provider' => $provider
            ]);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $name,
                'email' => $socialUser->getEmail(),
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
                'password' => bcrypt('123456dummy'), // only needed if you allow password login
            ]);
        }

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Optional: log out the user.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
