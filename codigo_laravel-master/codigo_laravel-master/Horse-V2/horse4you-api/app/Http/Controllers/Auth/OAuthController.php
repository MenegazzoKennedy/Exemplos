<?php

namespace App\Http\Controllers\Auth;

//use App\Exceptions\EmailTakenException;
use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use JWTAuth;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*config([
            'services.facebook.redirect' => route('auth.callback', 'facebook'),
            'services.google.redirect' => route('auth.callback', 'google'),
        ]);*/
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($provider)
    {
        $client_id = 'services.'.$provider.'.client_id';
        $client_id = config($client_id);

        return [
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
            'client_id' => $client_id,
            'client_callback' => "/auth/".$provider."/callback",
        ];        
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param  string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleCallback($provider)
    {       
        $user = Socialite::driver($provider)->stateless()->user();
        $user = $this->findOrCreateUser($provider, $user);

        $userCredentials = [
            'token' => $user->token,
            'refreshToken' => $user->refreshToken,
            'expiresIn' => $user->expiresIn,
        ];


        /*$token = Auth::guard()->attempt($user);

        return view('auth/callback', [
            'token' => $user->token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ]);
        */
        
        $token = JWTAuth::fromUser($user);
        //return redirect()->to('http://localhost:8000/?' . 'token=' . $token);

        return view('oauth/callback', [
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\Models\User
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

        /*if (User::where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException;
        }*/

        return $this->createUser($provider, $user);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\Models\User
     */
    protected function createUser($provider, $sUser)
    {
        $user = User::where('email',$sUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $sUser->getName(),
                'email' => $sUser->getEmail(),
                'password' => bcrypt(rand(10,1000)),
                'email_verified_at' => now(),
            ]);
        }       

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }

    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic
        $user = Socialite::driver($provider)->stateless()->user();
        $user['token'] = JWTAuth::fromUser($user);
        return response()->json($user);
    }
}