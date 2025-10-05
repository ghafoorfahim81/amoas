<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:roles show'])->only(['index']);
        $this->middleware(['permission:roles create'])->only(['store']);
        $this->middleware(['permission:roles edit'])->only(['edit', 'update']);
        $this->middleware(['permission:roles assign or revoke'])->only(['revoke', 'assign']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('users.role.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        \DB::beginTransaction();

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        \DB::commit();

        return redirect(route('roles.index'))->with(['alert' => 'Role Created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role->load(['permissions', 'users']);
        $users = \App\User::with('role')->whereIn('role_id', [1, 3])->get();
        $permissions = Permission::all();

        return view('users.role.edit', compact('users', 'permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        \DB::beginTransaction();

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        \DB::commit();

        return redirect(route('roles.index'))->with(['alert' => 'Role Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->users()->sync([]);
        $role->permissions()->sync([]);
        $role->delete();

        return back()->with(['alert' => 'Role has been deleted.']);
    }

    /**
     * revoke the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function revoke(Role $role)
    {
        $this->validate(request(), [
            'user_id' => 'required',
        ]);

        $role->users()->detach(request()->user_id);

        return back()->with(['alert' => 'Role revoke from user.']);
    }

    /**
     * revoke the specified resource from storage.
     *
     * @param  int  Role $role
     * @return \Illuminate\Http\Response
     */
    public function assign(Role $role)
    {
        $this->validate(request(), [
            'user_id' => 'required',
        ]);

        $role->users()->attach(request()->user_id);

        return back()->with(['alert' => 'Role assigned to user.']);
    }
}
