<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use App\Services\SocialAuthService;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdsInsights;
use FacebookAds\Object\AdCampaign;
use FacebookAds\Object\Values\InsightsPresets;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialAuthService $service)
    {
    	$user = $service->createOrGetUser(Socialite::driver('facebook')->user());
    	auth()->login($user);

        return redirect()->route('home');
    }

    public function redirect_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(SocialAuthService $service)
    {
    	$user = $service->createOrGetUserGoogle(Socialite::driver('google')->user());
    	auth()->login($user);

        return redirect()->route('home');
    }
    
}
