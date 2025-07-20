<?php

namespace App\Services;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ForgotPasswordEmail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ForgotPasswordService
{
    public function saveToken(ForgotPasswordRequest $request, User $user): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $passwordReset = PasswordReset::where('email', $user->email)->first();
            $token = Str::random(64);

            if (!$passwordReset) {
                $passwordReset = PasswordReset::create([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
            } else {
                $passwordReset->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
            }

            Mail::to($user->email)->send(new ForgotPasswordEmail($user, $token));

            DB::commit();

            return redirect()->route('forgot.password')->with('success', 'We have e-mailed your password reset link!');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }

    public function saveResetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $email = decrypt($request->email);

            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()->with('error', 'Invalid Email!');
            }
            $passwordReset = PasswordReset::where('email', $email)
            ->where('token', $request->token)
            ->first();

            if(!$passwordReset){
                return back()->with('error', 'Invalid token!');
            }

            $user->password = bcrypt($request->password);
            $user->save();

            PasswordReset::where('email', $email)->where('token', $request->token)->delete();

            DB::commit();
            return redirect()->route('login')->with('success', 'Your password has been changed!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}
