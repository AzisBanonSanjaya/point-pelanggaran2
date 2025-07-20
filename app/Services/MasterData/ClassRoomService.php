<?php

namespace App\Services\MasterData;

use App\Http\Requests\MasterData\ClassRoomRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\MasterData\ClassRoom;

class ClassRoomService
{
    public function save(ClassRoomRequest $request, ?ClassRoom $classRoom = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $code = '';
            if($request->name == 'Kelas X (10)'){
                $code = 'X-'.$request->major.'-'.$request->code;
            }elseif($request->name == 'Kelas XI (11)'){
                 $code = 'XI-'.$request->major.'-'.$request->code;
            }elseif($request->name == 'Kelas XII (12)'){
                 $code = 'XII-'.$request->major.'-'.$request->code;;
            }


            $data['code'] = $code;

            if ($classRoom) {
                $classRoom->update($data);
            } else {
                $classRoom = ClassRoom::create($data);
            }
           
            DB::commit();
            Log::channel('log-transaction')->info(($classRoom->wasRecentlyCreated ? 'Kelas Created!' : 'Kelas Updated!'), ['User' =>  Auth::user()->name]);
            return redirect()->route('class-room.index')->with('success', 'Data berhasil ' . ($classRoom->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!')); 
        
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(ClassRoom $classRoom): bool
    {
        DB::beginTransaction();
        try {
            $classRoom->update(['deleted_at' => now(), 'deleted_by' => Auth::id()]);
            DB::commit();
            Log::channel('log-transaction')->info('Kelas Delete Success!', ['User' =>  Auth::user()->name]);
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return false;
        }
    }
}
