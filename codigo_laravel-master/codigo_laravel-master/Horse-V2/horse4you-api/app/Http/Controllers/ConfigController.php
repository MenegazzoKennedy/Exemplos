<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigController extends Controller
{
    public function clearRoute()
    {
        Artisan::call('optimize');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return redirect()->route('home');
    }

    public function clearRouteApi()
    {
        Artisan::call('optimize');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        $cacheClear = [
            'msg' => 'Cache Clear exacutado API'
        ];

        return response()->json($cacheClear, 200);
    }
}
