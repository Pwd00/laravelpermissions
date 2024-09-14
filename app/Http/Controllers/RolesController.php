<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = ModelsRole::orderBy("created_at", "ASC")->paginate(1);
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
        $role = ModelsRole::findOr($id);
        $validator = validator::make($request->all(), [
            'name' => 'required:unique:roles,name,except,' . $id . ',id'
        ]);
        if ($validator->passes()) {
            $role->name = $request->input('name');
            $role->save();
            if (!empty($request->input('per'))) {
                $role->syncPermissions($request->input('per'));
            }
            return redirect()->route('roles.index')->with('success', 'Done Role updated Sucessfully');
        } else {
            redirect()->route('roles.edit')->withInput()->withErrors($validator);
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
