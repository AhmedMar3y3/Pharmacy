<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\Admin\login;
use App\Http\Requests\Admin\store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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
    public function loadLoginPage()
    {
        return view('login');
    }

    public function loginUser(login $request)
    {
        $request->validated();
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->with('error', 'البريد الالكتروني او كلمة المرور غير صحيحة');
        }

        Auth::login($user);   
        return redirect()->route('dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
    }


    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return redirect()->route('loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
