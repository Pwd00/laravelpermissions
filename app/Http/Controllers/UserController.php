<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class UserController extends Controller  implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:edit user', only: ['edit']),
            new Middleware('permission:create user', only: ['create']),
            new Middleware('permission:delete user', only: ['delete']),
        ];
    }
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[\pL\pN\s\-]+$/u',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|same:cpassword',
            'cpassword' => 'required|min:4'
        ]);
        if ($validator->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        } else {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            $roles = $request->input('role', []);
            $user->syncRoles($roles);
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        if ($hasRoles) {
            return view('users.edit', compact('user',  'roles', 'hasRoles'));
        } else {
            return view('users.edit', compact('user',  'roles'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all());
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[\pL\pN\s\-]+$/u',
            'email' => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|unique:users,email,' . $id,
        ]);
        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
        } else {
            $user->update($validator->validated());
            $roles = $request->input('role', []);

            $user->SyncRoles($roles);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted successfully.');

    }
}
