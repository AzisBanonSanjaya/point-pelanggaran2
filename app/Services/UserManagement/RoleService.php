<?php

namespace App\Services\UserManagement;

use App\Http\Requests\UserManagement\RoleRequest;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function save(RoleRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request->id) {
                $roles = Role::find($request->id);
                $roles->update($data);
            } else {
                $roles = Role::create($data);
            }
            if(!empty($roles['id'])){
                $roles->syncPermissions($data['permission_id']);
                DB::commit();
                Log::channel('log-transaction')->info(($roles->wasRecentlyCreated ? 'Role Created!' : 'Role Updated!'), ['User' =>  Auth::user()->name]);
                return redirect()->route('user.index')->with('success', 'Data Role berhasil ' . ($roles->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Role $role): JsonResponse
    {
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            Log::channel('log-transaction')->info('Role Delete Success!', ['User' =>  Auth::user()->name]);
            return response()->json([
                'message' => 'Data berhasil dihapus.',
                'status' => true,
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return response()->json([
                'message' => 'Data Gagal Di hapus.',
                'status' => false,
            ], JsonResponse::HTTP_OK);

        }
    }
}
