<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
 ********************************/
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }


        $user = Auth::guard('admin')->user();

        $adminRoleIds = [1];

        if (!in_array($user->role_id, $adminRoleIds)) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('error', 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}
