<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\ProfileRequest;
use App\Services\UserManagement\ProfileService;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;

    }
    public function index(): View|Factory
    {
        $profile = Auth::user();
        return view('backEnd.userManagement.profile.index', compact('profile'));
    }

    public function store(ProfileRequest $request): RedirectResponse
    {
        return $this->profileService->save($request);
    }

}
