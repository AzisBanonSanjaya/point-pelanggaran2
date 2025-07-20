<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\RoleRequest;
use Auth;
use App\Services\UserManagement\RoleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private Permission $permissions;
    private Role $roles;
    private RoleService $roleService;

    public function __construct(Permission $permissions, Role $roles, RoleService $roleService)
    {
        $this->permissions = $permissions;
        $this->roles = $roles;
        $this->roleService = $roleService;
        $this->middleware('permission:role-create', ['only' => ['store']]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        return $this->roleService->save($request);
    }

    public function destroy(Role $role): JsonResponse
    {
       return $this->roleService->delete($role);
    }
}
