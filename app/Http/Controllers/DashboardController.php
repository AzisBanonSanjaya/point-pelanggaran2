<?php

namespace App\Http\Controllers;

use App\Models\MasterData\IntervalPoint;
use App\Models\SanctionDecision;
use App\Models\User;
use Auth;
use DB;
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
        $totalPelanggaranByMonth = SanctionDecision::whereMonth('report_date', now()->format('m'))->count();
        $totalSiswa = User::whereHas('roles', function($q){
            $q->where('name', 'User');
        })->count();

        $sanctions = SanctionDecision::select('user_id', 'status', 'code', 'id', 'file','description', 'created_by','report_date', 'reason_reject', DB::raw('SUM(total_point) as total_point_sum'))
        ->with('student.classRoom.user', 'sanctionDecisionDetail.category','userCreated')
        ->groupBy('user_id', 'code', 'id', 'status','file','description','created_by','reason_reject','report_date')
        ->orderByDesc('report_date')
        ->limit(10)
        ->get();


        $totalGuru = User::whereHas('roles', function($q){
            $q->whereIn('name', ['Teacher','Guru Bk']);
        })->count();

        $sanksis = SanctionDecision::all();
        $intervals = IntervalPoint::all();

        $urgensiCount = [
            'ringan' => 0,
            'sedang' => 0,
            'berat' => 0,
        ];

        foreach ($sanksis as $sanksi) {
            $interval = $intervals->first(function ($item) use ($sanksi) {
                return $sanksi->total_point >= $item->from && $sanksi->total_point <= $item->to;
            });

            if ($interval) {
                $type = strtolower($interval->type);
                if (isset($urgensiCount[$type])) {
                    $urgensiCount[$type]++;
                }
            }
        }

        return view('backEnd.dashboard.index', compact("totalPelanggaran","urgensiCount","totalSiswa", "totalGuru","totalPelanggaranByMonth","sanctions"));
    }
}
