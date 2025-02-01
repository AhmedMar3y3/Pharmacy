<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\login;
use App\Http\Requests\Admin\store;
use Illuminate\Http\Request;
use App\Models\User; 


class AuthController extends Controller
{


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
    

    // public function login(login $request)
    // {
    //     $validatedData = $request->validated();
    //     $user = User::where('email', $request->input('email'))->first();
    //     if (!$user || !Hash::check($request->input('password'), $user->password)) {

    //         return response()->json([
    //             'message' => 'بيانات الاعتماد غير صحيحة'
    //         ], 401);
    //     }

    //     $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;
    
    //     return response()->json([
    //         'user' => $user,
    //         'token' => $token
    //     ]);
    // }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'message' => $user->name . ' تم تسجيل الخروج بنجاح'
            ]);
        }
        
        return response()->json([
            'message' => 'لم يتم العثور على مستخدم مسجل دخول'
        ], 401);
    }
    
    

    
}
