<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagController extends Controller
{
    public function dashbord(){
        return Inertia::render('Dashboard');
    }
    public function chat(){
        return Inertia::render('Chat');
    }
}
