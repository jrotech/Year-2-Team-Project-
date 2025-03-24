<?php
/********************************
Developer: Abdullah Alharbi, Iddrisu Musah
********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\CustomerSimulationController;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    
        \Log::info('Attempting admin login', ['credentials' => $credentials]);
    
        if (Auth::guard('admin')->attempt($credentials)) {
            \Log::info('Admin guard login successful');
            // Regenerate session after admin login.
            $request->session()->regenerate();
    
            // Get the admin user.
            $admin = Auth::guard('admin')->user();
            \Log::info('Admin user logged in', ['admin_id' => $admin->id, 'email' => $admin->email]);
    
            // Instantiate the CustomerSimulationController and simulate a customer record.
            $customerSimController = new \App\Http\Controllers\CustomerSimulationController();
            $customer = $customerSimController->simulate();
            \Log::info('Simulated customer', ['customer_id' => $customer ? $customer->id : 'null', 'email' => $customer ? $customer->email : 'null']);
    
            // Log in the simulated customer on the default (web) guard.
    
            if(Auth::attempt(['email' => $customer->email, 'password' => 'defaultpassword'])) {	
                
                \Log::info('Customer guard login successful');
                // Regenerate session after customer login.
                $request->session()->regenerate();
    
                // Get the customer user.
                $customer = Auth::user();
                \Log::info('Customer user logged in', ['customer_id' => $customer->id, 'email' => $customer->email]);
            }
          
            return redirect()->intended(route('admin.dashboard'));
        }
    
        \Log::error('Admin login failed', ['credentials' => $credentials]);
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
            'password'         => 'required|confirmed|min:8',
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
