<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'كلمة المرور الحالية غير صحيحة.']);
            }

            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }
        }
    

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        
        $user->save();
    
        return redirect()->route('profile.index')->with('success', 'تم تحديث المستخدم بنجاح.');
    }


    public function checkAndUpdatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة');
        }
    
        $request->validate([
            'new_password' => 'required|min:6',
        ]);
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->back()->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
    
}