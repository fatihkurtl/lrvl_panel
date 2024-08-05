<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function loginIndex()
    {
        if (Auth::check()) {
            return redirect()->route('admin-dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->route('admin-dashboard');
        }
        return back()->withErrors([
            'email' => 'E-posta ya da şifre yanlış.',
        ]);
    }

    public function registerIndex()
    {
        if (Auth::check()) {
            return redirect()->route('admin-dashboard');
        }
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'confirm-password' => 'required|same:password',
            'terms' => 'required',
        ], [
            'name.required' => 'Ad alanı zorunludur.',
            'email.required' => 'Email alanı zorunludur.',
            'email.unique' => 'Bu email adresi ile daha önce kayıt olunmamalıdır.',
            'password.required' => 'Şifre alanı zorunludur.',
            'confirm-password.required' => 'Şifre tekrarı alanı zorunludur.',
            'confirm-password.same' => 'Şifreler uyusmuyor.',
            'terms.required' => 'Sozlesme kabul edilmesi zorunludur.',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect()->route('admin-register')->with('success', 'Kayıt olundu, Lütfen giriş yapın...');
    }

    public function logout()
    {
        Auth::logout();
        return view('admin.auth.login');
    }    
}
