<?php

namespace App\Services;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SanctionDecision;
use App\Models\SanctionDecisionDetail;

class SanctionDecisionService
{
    public function save(Request $request, ?SanctionDecision $sanctionDecision = null): RedirectResponse
    {
        DB::beginTransaction();
        try {

            if(count($request->category_id) == 0){
                  return back()->with('error', 'Data Sanksi Wajib Dipilih');
            }
            $data = [
                'user_id' => $request->user_id,
                'code' => $request->code,
                'report_date' => $request->report_date,
                'total_point' => $request->total_point,
                'created_by' => Auth::id(),
            ];

            if ($sanctionDecision) {
                $sanctionDecision->sanctionDecisionDetail()->delete();
                $sanctionDecision->update(['updated_by' => Auth::id(), 'total_point' => $request->total_point, 'status' => $sanctionDecision->status == 4 ? 1 : $sanctionDecision->status ]);
            } else {
                $sanctionDecision = SanctionDecision::create($data);
            }
           
            $this->sanctionDecisionDetail($sanctionDecision, $request);
            DB::commit();
            Log::channel('log-transaction')->info(($sanctionDecision->wasRecentlyCreated ? 'Penentuan Sanksi Created!' : 'Penentuan Sanksi Updated!'), ['User' =>  Auth::user()->name]);
            return redirect()->route('penentuan-sanksi.index')->with('success', 'Data berhasil ' . ($sanctionDecision->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!')); 
        
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(SanctionDecision $sanctionDecision): bool
    {
        DB::beginTransaction();
        try {
            $sanctionDecision->update(['deleted_at' => now(), 'deleted_by' => Auth::id()]);
            DB::commit();
            Log::channel('log-transaction')->info('Kelas Delete Success!', ['User' =>  Auth::user()->name]);
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return false;
        }
    }

    private function sanctionDecisionDetail($sanctionDecision, $request){
        if($sanctionDecision->id){
            foreach($request->category_id as $key => $category_id){
                SanctionDecisionDetail::create([
                    'sanction_decision_id' => $sanctionDecision->id,
                    'category_id' => $category_id,
                    'incident_date' => $request->incident_date[$key],
                    'comment' => $request->comment[$key] ?? null,
                ]);
            }

            return true;
        }
        return false;
    }
}
