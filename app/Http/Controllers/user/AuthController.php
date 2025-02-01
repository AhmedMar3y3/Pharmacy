<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\user\login;
use App\Http\Requests\user\store;
use App\Models\User;

class AuthController extends Controller
{

    public function loadLogin()
    {
        return view('login');
    }

    public function login(login $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return redirect()->route('login.page');
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.home');
    }


    public function dashboard()
    {
        return view('dashboard');
    }
}
