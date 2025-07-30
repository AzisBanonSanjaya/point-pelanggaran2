<?php

namespace App\Http\Controllers;

use App\Mail\SubmittedMail;
use App\Models\MasterData\Category;
use App\Models\MasterData\ClassRoom;
use App\Models\MasterData\IntervalPoint;
use App\Models\SanctionDecision;
use App\Models\SanctionDecisionDetail;
use App\Models\User;
use App\Services\SanctionDecisionService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Mail;

class SanctionDecisionController extends Controller
{

    private SanctionDecisionService $sanctionDecisionService;

    public function __construct(SanctionDecisionService $sanctionDecisionService)
    {
        $this->sanctionDecisionService = $sanctionDecisionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Factory|View
    {
        $sanctions = SanctionDecision::select('user_id', 'status', 'code', 'id', 'file','description', 'created_by', 'reason_reject', DB::raw('SUM(total_point) as total_point_sum'))
        ->with('student.classRoom.user', 'sanctionDecisionDetail.category','userCreated')
        ->groupBy('user_id', 'code', 'id', 'status','file','description','created_by','reason_reject')
        ->orderByDesc('total_point_sum')
        ->get();
        
        return view('backEnd.sanctionDecision.index', compact('sanctions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sanctionsUser = SanctionDecision::pluck('user_id')->toArray();
        $classRooms = ClassRoom::pluck('name')->unique()->toArray();
        $categories = Category::get(['id','name','point']);
        $calculatePoint = IntervalPoint::get(['id','name','from', 'to', 'type'])->toJson();
        
        return view('backEnd.sanctionDecision.create', compact('categories','calculatePoint','classRooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       return $this->sanctionDecisionService->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sanctionDecision = SanctionDecision::with('student.classRoom','sanctionDecisionDetail.category')->find($id);
        if(!$sanctionDecision){
            return redirect()->route('penentuan-sanksi.index')->with('error', 'Data Tidak Ada');
        }
        $categories = Category::get(['id','name','point']);
        $calculatePoint = IntervalPoint::get(['id','name','from', 'to', 'type'])->toJson();
        
        return view('backEnd.sanctionDecision.edit', compact('sanctionDecision','categories','calculatePoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $sanctionDecision = SanctionDecision::find($id);
        return $this->sanctionDecisionService->save($request, $sanctionDecision);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteDetail($id){
        $detail = SanctionDecisionDetail::with('sanctionDetail')->find($id);
        $sanctionDecision = SanctionDecision::find($detail->sanction_decision_id);
        $detail->sanctionDetail->update(['total_point' => $detail->sanctionDetail->total_point - $detail->category->point]);
        $detail->delete();
        if($sanctionDecision->sanctionDecisionDetail->isEmpty()){
            $sanctionDecision->delete();
        }
        
       return response()->json([
            'status' => true
       ]);
    }

    public function submitted(Request $request, $id)
    {
         DB::beginTransaction();

        try {
            $sanctionDecision = SanctionDecision::find($id);

            if (!$sanctionDecision) {
                return redirect()->back()->with('error', 'Data Tidak Ada');
            }

            // Handle file upload jika ada
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($sanctionDecision->file && Storage::disk('public')->exists($sanctionDecision->file)) {
                    Storage::disk('public')->delete($sanctionDecision->file);
                }

                $file = $request->file('file');
                $filePath = $file->store('sanksi', 'public');
            } else {
                $filePath = null;
            }

            $sanctionDecision->update([
                'file' => $filePath,
                'description' => $request->description,
                'status' => 2
            ]);

            DB::commit();
            // Mail::to('azisbanon01@gmail.com')->send(new SubmittedMail($sanctionDecision));
            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
