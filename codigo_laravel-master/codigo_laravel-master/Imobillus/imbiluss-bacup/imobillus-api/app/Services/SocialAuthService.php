<?php

namespace App\Services;

use App\User;
use App\SocialLogin;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Events\EventNovoRegistro;

class SocialAuthService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialLogin::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialLogin([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => bcrypt(rand(1, 9999))
                ]);

                //event(new EventNovoRegistro($user));
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }

    public function createOrGetUserGoogle(ProviderUser $providerUser)
    {
        $account = SocialLogin::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialLogin([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => bcrypt(rand(1, 9999))
                ]);

                //event(new EventNovoRegistro($user));
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }

}