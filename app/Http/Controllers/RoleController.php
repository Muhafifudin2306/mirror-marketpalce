<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\View\View;
use App\Models\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('role-management'); 

        $roles = Role::with('permissions')->orderBy('id', 'DESC')->paginate(5);

        return view('roles.index', compact('roles'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('role-manipulation'); 

        $permissions = Permission::get();
    
        return view('roles.create', compact('permissions'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->authorize('role-manipulation'); 

        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
                ->withSuccess('Role berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(): RedirectResponse
    {
        $this->authorize('role-manipulation'); 

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $this->authorize('role-manipulation'); 

        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();
    
        $permissions = Permission::get();
    
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $this->authorize('role-manipulation'); 

        $input = $request->all();

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);    
        
        return redirect()->route('roles.index')
                ->withSuccess('Role berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('role-manipulation'); 
        
        $role->delete();
        return redirect()->route('roles.index')
                ->withSuccess('Role berhasil dihapus!');
    }
}