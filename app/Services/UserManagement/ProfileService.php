<?php

namespace App\Services\UserManagement;

use App\Http\Requests\UserManagement\ProfileRequest;
use App\Http\Traits\ImageTrait;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    use ImageTrait;

    public function save(ProfileRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $userExists = [
                'email' => Auth::user()->email,
                'password' => $data['old_password'],
            ];
            if (!Auth::attempt($userExists)) {
                return redirect()->route('profile.index')->with('error', 'The old password does not match our records.');
            }

            $dataUser  = [
                "password" => bcrypt($data['password']),
            ];
            if ($request->hasFile('image')) {
                $dataUser['image'] = $this->storeImage('user',$request->file('image'));
                $profile = Auth::user();
                $this->deleteImage('user', $profile);
            }
            $users = User::find(Auth::user()->id)->update($dataUser);
            Log::channel('log-transaction')->info('Profile Updated', ['User' =>  Auth::user()->name]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            DB::commit();
            return redirect()->route('login')->with('success', 'Update Profile Berhasil');
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  NULL]);
            return back()->with('error', $e->getMessage());
        }
    }
}
