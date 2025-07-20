<?php

namespace App\Services\MasterData;

use App\Http\Requests\MasterData\IntervalPointRequest;
use App\Models\MasterData\IntervalPoint;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IntervalPointService
{
    public function save(IntervalPointRequest $request, ?IntervalPoint $intervalPoint = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($intervalPoint) {
                $intervalPoint->update($data);
            } else {
                $intervalPoint = IntervalPoint::create($data);
            }
           
            DB::commit();
            Log::channel('log-transaction')->info(($intervalPoint->wasRecentlyCreated ? 'Interval Point Pelanggaran Created!' : 'Interval Point Updated!'), ['User' =>  Auth::user()->name]);
            return redirect()->route('interval.index')->with('success', 'Data berhasil ' . ($intervalPoint->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!')); 
        
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(IntervalPoint $intervalPoint): bool
    {
        DB::beginTransaction();
        try {
            $intervalPoint->update(['deleted_at' => now(), 'deleted_by' => Auth::id()]);
            DB::commit();
            Log::channel('log-transaction')->info('Interval Point Delete Success!', ['User' =>  Auth::user()->name]);
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return false;
        }
    }
}
