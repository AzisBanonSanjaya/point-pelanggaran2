<?php

namespace App\Http\Controllers\dataMaster;

use App\Http\Controllers\Controller;
use App\Http\Requests\dataMaster\KelasRequest;
use App\Models\DataMaster\Kelas;
use App\Services\dataMaster\KelasService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class KelasController extends Controller
{
    private Kelas $kelas;
    private KelasService $kelasService;

    public function __construct(Kelas $kelas, KelasService $kelasService)
    {
        $this->kelas = $kelas;
        $this->kelasService = $kelasService;
    }

    public function index(): View|Factory
    {
        $kelas = $this->kelas->orderBy('id')->get();
        return view('backEnd.dataMaster.kelas.index', compact('kelas'));

    }

    public function store(KelasRequest $request): RedirectResponse
    {
        return $this->kelasService->save($request);
    }

    public function show(Category $kelas): JsonResponse
    {
        if(!$kelas){
            return response()->json([
                'status'  => false,
                'message' => 'Data Not Found',
            ], JsonResponse::HTTP_OK);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Data Not Found',
            'data'  => $kelas
        ], JsonResponse::HTTP_OK);
    }
}
