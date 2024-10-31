<?php

namespace App\Services\UserManagement;

use App\Http\Requests\UserManagement\PermissionRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function save(PermissionRequest $request, ?Permission $permissions = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($permissions) {
                $permissions->update($data);
            } else {
                $permissions = Permission::create($data);
            }
            if(!empty($permissions['id'])){
                DB::commit();
                Log::channel('log-transaction')->info(($permissions->wasRecentlyCreated ? 'Permission Created!' : 'Permission Updated!'), ['User' =>  Auth::user()->name]);
                return redirect()->route('permission.index')->with('success', 'Data berhasil ' . ($permissions->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Permission $permissions): bool
    {
        DB::beginTransaction();
        try {
            $permissions->delete();
            DB::commit();
            Log::channel('log-transaction')->info('Permission Delete Success!', ['User' =>  Auth::user()->name]);
            return TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return FALSE;
        }
    }
}
