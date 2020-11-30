<?php

namespace App\Http\Controllers\Auth\Custom;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $request = $request->toArray();
        if (User::login($request)) {
            return redirect('home');
        } else {
            return redirect('login');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }
}
