<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('backend/user.login');
    }

    public function masukLogin(Request $request)
    {
        request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );
        $kredensil = $request->only('username', 'password');

        if (Auth::attempt($kredensil)) {
            $user = Auth::user();
            if ($user->level_id == 1) {
                return redirect()->intended('dashboardadmin');
            } elseif ($user->level_id == 2) {
                return redirect()->intended('dashboardtentor');
            } elseif ($user->level_id == 3) {
                return redirect()->intended('dashboardsiswa');
            }
            return redirect()->intended('masuklogin');
        }
        return back()->with('loginError', 'Username atau Password Anda Salah !!!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
