<?php
/********************************
Developer: [Your Name]
University ID: [Your ID]
 ********************************/
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in with admin guard
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Check if the user has the admin role
        $user = Auth::guard('admin')->user();

        // Get the admin roles (you might want to define this in your env or config)
        $adminRoleIds = [1]; // Assuming role_id 1 is for admins

        if (!in_array($user->role_id, $adminRoleIds)) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('error', 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}
