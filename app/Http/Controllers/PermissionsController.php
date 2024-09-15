<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use function Laravel\Prompts\alert;

class PermissionsController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:create permission', only: ['create']),
            new Middleware('permission:edit permission', only: ['edit']),
            new Middleware('permission:delete permission', only: ['destory']),
        ];
    }
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(5);
        return view("Permission.list", compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view("Permission.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:permissions|min:3"
        ]);
        // dd($validator);
        if ($validator->passes()) {
            Permission::create($validator->validated());
            return redirect()->route("permission.index")->with('success', 'Permission  created Sucssfully');
        } else {
            return redirect()->route('permission.create')->withInput()->withErrors($validator);
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
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:permissions,name,' . $id
        ]);
        if ($validator->passes()) {
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permission.index')->with('success', 'Permission Updated SucesssFully.');
        } else {
            return redirect()->route('permission.edit', [$id])->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('error', 'Permisssion Deleted Sucesfully');
    }
}
