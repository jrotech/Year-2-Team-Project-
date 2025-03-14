<?php
/********************************
Developer: Abdullah Alharbi
University ID: 230046409
 ********************************/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('role')->orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * disply the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

            'role_id' => 'required|exists:roles,id',
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);


        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * update the selected user .
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->name = $request->name;

        $user->email = $request->email;

        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * remove the selected user from storage.
     */
    public function destroy(User $user)
    {


        if ($user->id === auth()->guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')

            ->with('success', 'User deleted successfully');
    }
}
