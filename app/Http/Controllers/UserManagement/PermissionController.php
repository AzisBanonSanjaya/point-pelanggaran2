<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\PermissionRequest;
use App\Services\UserManagement\PermissionService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private Permission $permissions;
    private PermissionService $permissionService;

    public function __construct(Permission $permissions, PermissionService $permissionService)
    {
        $this->permissions = $permissions;
        $this->permissionService = $permissionService;
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View|Factory
    {
        $permissions = $this->permissions->orderBy('id')->get();
        return view('backEnd.userManagement.permission.index', compact('permissions'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        return $this->permissionService->save($request);
    }

    public function show(Permission $permission): JsonResponse
    {
        if(!empty($permission)){
            return response()->json([
                'status'  => true,
                'data'    => $permission,
                'message' => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Tidak Ada.',
                'data'    => [],
                'roles'   => [],
                'permissions' => [],
                'status' => false,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        return $this->permissionService->save($request, $permission);
    }


    public function destroy(Permission $permission)
    {
        $service = $this->permissionService->delete($permission);
        if($service){
            return response()->json([
                'message' => 'Data berhasil dihapus.',
                'status' => true,
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Gagal Di hapus.',
                'status' => false,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
