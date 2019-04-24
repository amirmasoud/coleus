<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Models\OAuthProvider;
use App\Exceptions\EmailTakenException;
use Laravel\Socialite\Facades\Socialite;
use Facades\App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OAuthRepository
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        config([
            'services.github.redirect' => env('FRONT_URL') . '/oauth/github/callback',
            'services.google.redirect' => env('FRONT_URL') . '/oauth/google/callback',
        ]);
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return [
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ];
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param  string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider, $code)
    {
        request()->merge(['code' => $code]);
        $user = Socialite::driver($provider)->stateless()->user();
        $user = $this->findOrCreateUser($provider, $user);

        $this->guard()->setToken(
            $token = $this->guard()->login($user)
        );

        return [
            'token' => $token
        ];
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $user
     * @return \App\User|false
     */
    protected function findOrCreateUser($provider, $user)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]);

            return $oauthProvider->user;
        }

        if (User::where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException;
        }

        return $this->createUser($provider, $user);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $user
     * @return \App\User
     */
    protected function createUser($provider, $user)
    {
        $user = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' => UserRepository::username(13)
        ]);

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $user->getId(),
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
        ]);

        return $user;
    }
}
