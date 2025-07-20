<?php

namespace App\Http\Controllers;

use App\Mail\ApproveMail;
use App\Mail\RejectMail;
use App\Models\SanctionDecision;
use Illuminate\Http\Request;
use App\Models\Violation;
use DB;
use Mail;

class ViolationManagementController extends Controller
{
    /**
     * Display a listing of the student violations.
     */
    public function index(Request $request)
    {
       $sanctions = SanctionDecision::select('user_id', 'status', 'code', 'id', 'file','description','reason_reject', DB::raw('SUM(total_point) as total_point_sum'))
        ->with('student.classRoom.user', 'sanctionDecisionDetail.category')
        ->whereIn('status', [2,3,4])
        ->groupBy('user_id', 'code', 'id', 'status','file','description','reason_reject')
        ->orderByDesc('total_point_sum')
        ->get();
        return view('backEnd.violationManagement.index', compact('sanctions'));
    }

    public function approve(Request $request)
    {
        DB::beginTransaction();

        try {
            $sanctionDecision = SanctionDecision::find($request->id);

            if (!$sanctionDecision) {
                return response()->json([
                    'status' => false,
                ]);
            }

            // Handle file upload jika ada
            $sanctionDecision->update([
                'status' => 3
            ]);

            DB::commit();
            Mail::to('azisbanon01@gmail.com')->send(new ApproveMail($sanctionDecision));
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
            ]);
        }
    }
     public function reject(Request $request)
    {
        DB::beginTransaction();

        try {
            $sanctionDecision = SanctionDecision::find($request->id);

            if (!$sanctionDecision) {
                return response()->json([
                    'status' => false,
                ]);
            }

            // Handle file upload jika ada
            $sanctionDecision->update([
                'status' => 4,
                'reason_reject' => $request->alasan
            ]);

            DB::commit();
            Mail::to('azisbanon01@gmail.com')->send(new RejectMail($sanctionDecision));
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
