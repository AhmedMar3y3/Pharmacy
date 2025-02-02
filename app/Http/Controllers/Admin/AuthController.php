<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\login;
use App\Http\Requests\Admin\store;
use App\Models\User;


class AuthController extends Controller
{

// Api
    public function register(store $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json([
            'user' => $user,
            'message' => 'تم التسجيل بنجاح',
        ], 201);
    }

    //web
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
    Auth::guard('web')->logout(); 

    request()->session()->invalidate(); 
    request()->session()->regenerateToken(); 

    return redirect()->route('login.page'); 
}






}
