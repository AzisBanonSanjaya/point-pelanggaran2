<?php

namespace App\Http\Controllers;

use App\Models\SanctionDecision;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:dashboard', ['only' => ['__invoke']]);
    }

    public function __invoke()
    {
        $totalPelanggaran = SanctionDecision::count();
        $totalSiswa = User::whereHas('roles', function($q){
            $q->where('name', 'User');
        })->count();
        $totalGuru = User::whereHas('roles', function($q){
            $q->whereIn('name', ['Teacher','Guru Bk']);
        })->count();

        return view('backEnd.dashboard.index', compact("totalPelanggaran","totalSiswa", "totalGuru"));
    }
}
