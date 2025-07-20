<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\IntervalPointRequest;
use App\Models\MasterData\IntervalPoint; // Pastikan model Interval di-import
use App\Services\MasterData\IntervalPointService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntervalPointController extends Controller
{

    private IntervalPointService $intervalPointService;

    public function __construct(IntervalPointService $intervalPointService)
    {
        $this->intervalPointService = $intervalPointService;
    }

    public function index()
    {
        $intervalPoints = IntervalPoint::orderBy('from')->get(); // Ambil semua data dari tabel intervals
        return view('backEnd.masterData.intervalPoint.index', compact('intervalPoints'));
    }

    // Menyimpan data interval baru ke database
    public function store(IntervalPointRequest $request)
    {
        return $this->intervalPointService->save($request);

       
    }
    // Menampilkan form edit data interval
    public function show($id)
    {
        $intervalPoint = IntervalPoint::findOrFail($id);
        if(!$intervalPoint){
            return response()->json([
                'status'  => false,
                'message' => 'Data Not Found',
            ], JsonResponse::HTTP_OK);
        }

         return response()->json([
            'status'  => true,
            'message' => 'Data Berhasil',
            'data'  => $intervalPoint,
        ], JsonResponse::HTTP_OK);
       
    }   

    // Menyimpan perubahan data interval ke database
    public function update(IntervalPointRequest $request, $id)
    {
        $intervalPoint = IntervalPoint::findOrFail($id);
        return $this->intervalPointService->save($request, $intervalPoint);
    }

    public function destroy($id): JsonResponse
    {
         $intervalPoint = IntervalPoint::findOrFail($id);
         $response = $this->intervalPointService->delete($intervalPoint);

        if(!$response){
             return response()->json([
                'status'  => false,
                'message' => 'Failed Delete',
            ], JsonResponse::HTTP_OK);
        }

           return response()->json([
                'status'  => true,
                'message' => 'Success Delete',
            ], JsonResponse::HTTP_OK);
    }

}
