<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class RolesController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:create role', only: ['create']),
            new Middleware('permission:edit role', only: ['edit']),
            new Middleware('permission:delete role', only: ['destory']),
        ];
    }
    public function index()
    {
        //
        $roles = ModelsRole::orderBy("created_at", "ASC")->paginate(10);
        return view("roles.index", compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::orderBy('created_at', 'asc')->get();
        return view("roles.create", compact("permission"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required|unique:roles|min:3"
        ]);
        if ($validator->passes()) {
            $role = ModelsRole::create($validator->validated());
            if (!empty($request->per)) {
                foreach ($request->per as $pname) {
                    $role->givePermissionTo($pname);
                }
            }
            return redirect()->route("roles.index")->with("success", "Roles Added Sucessfully");
        } else {
            return redirect()->route("roles.create")->withInput()->withErrors($validator);
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
        $role = ModelsRole::find($id);
        $hasPermission = $role->permissions->pluck('name');
        $permission = Permission::orderBy('created_at', 'asc')->get();
        return view('roles.edit', compact('role', 'hasPermission', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Retrieve the role or fail
        $role = ModelsRole::findOrFail($id);

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        if ($validator->passes()) {
            $role->name = $request->input('name');
            $role->save();
            $permissions = $request->input('per', []);
            $role->syncPermissions($permissions);

            // Redirect with success message
            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } else {
            // Redirect back with input and errors
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = ModelsRole::findOrFail($id);
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role Deleted Successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('roles.index')->with('error', 'Role not found');
        } catch (QueryException $e) {
            return redirect()->route('roles.index')->with('error', 'An error occurred while deleting the role');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'An unexpected error occurred');
        }
    }
}
