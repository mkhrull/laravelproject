<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    function home()
    {
        return view("auth.login");
    }

    function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8",
        ]);

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate session
            return redirect()->intended(route("admindashboard"));
        }

        return redirect(route("login"))->with("error", "Login failed");
    }

    function register()
    {
        return view("register");
    }

    function createuser()
    {
        return view("createuser");
    }

    function panotest()
    {
        return view("panotest");
    }

    function registerPost(Request $request)
    {
        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return redirect()->route("register")->with('error', 'Email already exists');
        }

        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "phonenum" => "required|min:10|max:11",
            "password" => "required|min:8",
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenum = $request->phonenum;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route("login"))->with("success", "User created successfully!");
        }

        return redirect(route("register"))->with("error", "Failed to create user");
    }

    function createuserPost(Request $request)
    {
        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return redirect()->route("createuser")->with('error', 'Email already exists');
        }

        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "phonenum" => "required|min:10|max:11",
            "password" => "required|min:8",
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenum = $request->phonenum;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route("admindashboard"))->with("success", "User created successfully!");
        }

        return redirect(route("createuser"))->with("error", "Failed to create user");
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout(); // Logout the currently authenticated user
            $request->session()->invalidate(); // Invalidate the session
            $request->session()->regenerateToken(); // Regenerate CSRF token
            return redirect(route('login'))->with('success', 'You have been logged out successfully.');
        } else {
            return redirect(route('login'))->with('error', 'You are already logged out.');
        }
    }
}
