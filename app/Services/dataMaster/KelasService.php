<?php

namespace App\Services\dataMaster;

use App\Http\Requests\dataMaster\KelasRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\DataMaster\Kelas;
// use Spatie\Kelas\Models\Kelas;

class KelasService
{
    public function save(KelasRequest $request, ?Kelas $kelas = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            // dd($data);
            if ($kelas) {
                $kelas->update($data);
            } else {
                $kelas = Kelas::create($data);
            }
            if(!empty($kelas['id'])){
                DB::commit();
                Log::channel('log-transaction')->info(($kelas->wasRecentlyCreated ? 'Kelas Created!' : 'Kelas Updated!'), ['User' =>  Auth::user()->name]);
                return redirect()->route('kelas.index')->with('success', 'Data berhasil ' . ($kelas->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!')); 
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Kelas $kelas): bool
    {
        DB::beginTransaction();
        try {
            $kelas->delete();
            DB::commit();
            Log::channel('log-transaction')->info('Kelas Delete Success!', ['User' =>  Auth::user()->name]);
            return TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return FALSE;
        }
    }
}
