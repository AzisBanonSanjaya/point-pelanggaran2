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

            if(count($request->category_id) == 0){
                  return back()->with('error', 'Data Sanksi Wajib Dipilih');
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
                $sanctionDecision->update(['created_by' => Auth::id(), 'total_point' => $request->total_point, 'status' => $request->total_point >= 76 ? 3 : 1, 'description' => null, 'file' => null]);
            } else {
                $sanctionDecision = SanctionDecision::create($data);
            }
           
            $this->sanctionDecisionDetail($sanctionDecision, $request);
            DB::commit();

            // if($request->total_point >= 20){
                Mail::to('azisbanon01@gmail.com')->send(new SanctionDecisionMail($sanctionDecision));
            // }
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

    private function sanctionDecisionDetail($sanctionDecision, $request)
    {
        if ($sanctionDecision->id) {
            // Ambil semua detail_id dari form
            $inputDetailIds = $request->detail_id ?? [];
            // Ambil semua detail yang sudah ada di DB untuk perbandingan
            $existingDetails = SanctionDecisionDetail::where('sanction_decision_id', $sanctionDecision->id)->get();

            foreach ($request->category_id as $key => $category_id) {
                $detailId = $inputDetailIds[$key] ?? null;

                if (!empty($request->file[$key])) {
                    $file = $this->storeImage('pelanggaran', $request->file[$key]);
                }

                if ($detailId) {
                    // Update detail jika ID ada
                    $detail = SanctionDecisionDetail::find($detailId);
                    if ($detail) {
                        $detail->update([
                            'category_id' => $category_id,
                            'incident_date' => $request->incident_date[$key],
                            'comment' => $request->comment[$key] ?? null,
                            'file' => $file ?? $detail->file,
                        ]);
                    }
                } else {
                    // Tambahkan jika tidak ada ID
                    SanctionDecisionDetail::create([
                        'sanction_decision_id' => $sanctionDecision->id,
                        'category_id' => $category_id,
                        'incident_date' => $request->incident_date[$key],
                        'comment' => $request->comment[$key] ?? null,
                        'file' => @$file ?? null,
                    ]);
                }
            }

            // // Hapus detail yang tidak lagi ada di request
            // $detailIdsToKeep = collect($inputDetailIds)->filter()->toArray(); // pastikan tidak null
            // dd($detailIdsToKeep, $request->all());
            // if(!empty($detailIdsToKeep)){

            //     SanctionDecisionDetail::where('sanction_decision_id', $sanctionDecision->id)
            //         ->whereNotIn('id', $detailIdsToKeep)
            //         ->delete();
            // }

            return true;
        }

        return false;
    }

}
