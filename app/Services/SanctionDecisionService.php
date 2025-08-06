<?php

namespace App\Services;

use App\Http\Traits\ImageTrait;
use App\Mail\SanctionDecisionMail;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SanctionDecision;
use App\Models\SanctionDecisionDetail;
use Mail;

class SanctionDecisionService
{
    use ImageTrait;
    
    public function save(Request $request, ?SanctionDecision $sanctionDecision = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            if (!$request->has('pelanggaran') || count($request->pelanggaran) == 0) {
                return back()->with('error', 'Data Pelanggaran Wajib Diisi')->withInput();
            }
            
            $data = [
                'user_id' => $request->user_id,
                'code' => $request->code,
                'report_date' => $request->report_date,
                'total_point' => $request->total_point,
                'created_by' => Auth::id(),
                'status' => $request->total_point >= 76 ? 3 : 1
            ];

            if ($sanctionDecision) {
                $sanctionDecision->update([
                    'created_by' => Auth::id(),
                    'total_point' => $request->total_point,
                    'status' => $request->total_point >= 76 ? 3 : 1
                ]);
            } else {
                $sanctionDecision = SanctionDecision::create($data);
            }
           
            $this->sanctionDecisionDetail($sanctionDecision, $request);
            DB::commit();

            Mail::to('azisbanon01@gmail.com')->send(new SanctionDecisionMail($sanctionDecision));

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

    private function sanctionDecisionDetail(SanctionDecision $sanctionDecision, Request $request)
    {
        if (!$request->has('pelanggaran')) {
            if ($sanctionDecision->id) {
                $sanctionDecision->details()->delete();
            }
            return;
        }

        $keptOrCreatedDetailIds = [];

        foreach ($request->pelanggaran as $key => $item) {
            $detailData = [
                'category_id' => $item['category_id'],
                'incident_date' => $item['incident_date'],
                'comment' => $item['comment'] ?? null,
            ];

            if (isset($item['file']) && $item['file']->isValid()) {
                $filePath = $this->storeImage('pelanggaran', $item['file']);
                $detailData['file'] = $filePath;
            }
            
            $detail = SanctionDecisionDetail::updateOrCreate(
                [
                    'id' => $item['detail_id'] ?? null,
                    'sanction_decision_id' => $sanctionDecision->id,
                ],
                $detailData
            );

            $keptOrCreatedDetailIds[] = $detail->id;
        }

        SanctionDecisionDetail::where('sanction_decision_id', $sanctionDecision->id)
                              ->whereNotIn('id', $keptOrCreatedDetailIds)
                              ->delete();
    }

}
