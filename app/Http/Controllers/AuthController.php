<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {    
        $title = 'Astra Report - Login';

        return view('auth.login',
        [
            'title' => $title
        ]);
    }
    
    public function registerView()
    {   
        $title = 'Astra Report - Register';

        return view('auth.register',
        [
            'title' => $title
        ]);
    }
    
    public function registerPost(Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required' , 'string' , 'min:8', 'confirmed']
        ]);

        User::create([
            'name' => $validatedRequest['name'],
            'email' => $validatedRequest['email'],
            'password' => bcrypt($validatedRequest['password']),
            'role' => 'dealer'
        ]);

        return redirect()->route('login-view');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dealers.index');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-view');
    }
}
