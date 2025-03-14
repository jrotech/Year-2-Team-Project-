<?php
/********************************
Developer: Abdullah Alharbi, Iddrisu Musah
University ID: 230046409, 230222232
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AdminAuthController extends Controller
{
    public function loginForm()
    {

        return view('admin.auth.login');

    }



    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()->route('admin.login');
    }

    public function changePasswordForm()
    {

        return view('admin.auth.change-password');
    }

    public function changePassword(Request $request)
    {

        $request->validate([

            'current_password' => 'required',

            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $user->password)) {

            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
         $user->save();

        return redirect()->route('admin.profile')

            ->with('success', 'Password changed successfully');
    }
}
