<?php

namespace App\Services\UserManagement;

use App\Http\Requests\UserManagement\UserRequest;
use App\Http\Traits\ImageTrait;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    use ImageTrait;
    public function save(UserRequest $request, ?User $users = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $roles = $data['role_id'];
            if ($request->hasFile('image')) {
                $data['image'] = $this->storeImage('user',$request->file('image'));
            }
            if ($users) {
                $this->deleteImage('user',$users, $request->hasFile('image'));
                if($data['password'] == $users->password){
                    unset($data['password']);
                }else{
                    $data['password'] = bcrypt($data['password']);
                }
                $users->update($data);
                DB::table('model_has_roles')->where('model_id',$users->id)->delete();
            } else {
                unset($data['role_id']);
                $users = User::create($data);
            }
            if(!empty($users['id'])){
                $users->assignRole($roles);
                DB::commit();
                Log::channel('log-transaction')->info(($users->wasRecentlyCreated ? 'User Created!' : 'User Updated!'), ['User' =>  Auth::user()->name]);
                return redirect()->route('user.index')->with('success', 'Data berhasil ' . ($users->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(User $user): bool
    {
        DB::beginTransaction();
        try {
            if(!empty($user)){
                if (Storage::disk('public')->exists('user') && !empty($user->image)) {
                    Storage::disk('public')->delete("user/{$user->image}");
                }
                $user->delete();
                DB::commit();
                Log::channel('log-transaction')->info('User Delete Success!', ['User' =>  Auth::user()->name]);
                return TRUE;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return FALSE;
        }
    }


}
