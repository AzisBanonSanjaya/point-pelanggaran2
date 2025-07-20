<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\ClassRoomRequest;
use App\Models\MasterData\ClassRoom;
use App\Models\User;
use App\Services\MasterData\ClassRoomService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ClassRoomController extends Controller
{
    private ClassRoomService $classRoomService;

    public function __construct(ClassRoomService $classRoomService)
    {
        $this->classRoomService = $classRoomService;
    }

    public function index(): View|Factory
    {
        $classRooms = ClassRoom::with('student')->orderBy('id')->get();

        $users = User::whereHas('roles', function ($query) {
                        $query->where('name', 'Teacher');
                    })->get();
        return view('backEnd.masterData.classRoom.index', compact('classRooms','users'));

    }

    public function store(ClassRoomRequest $request): RedirectResponse
    {
        return $this->classRoomService->save($request);
    }

    public function show(ClassRoom $classRoom): JsonResponse
    {
        if(!$classRoom){
            return response()->json([
                'status'  => false,
                'message' => 'Data Not Found',
            ], JsonResponse::HTTP_OK);
        }

        $explode = explode('-', $classRoom->code);
       

        $users = User::whereHas('roles', function ($query) {
                        $query->where('name', 'Teacher');
                    })
                    ->get();

        if($users->isNotEmpty()){
            $users->each(function ($user) use ($classRoom) {
                $user->selected = ($user->id === $classRoom->user_id) ? 'selected' : '';
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Data Berhasil',
            'data'  => $classRoom,
            'users' => $users,
            'alphabets' => range('A', 'Z'),
            'selectedAlphabet' => $explode[2] ?? null,
        ], JsonResponse::HTTP_OK);
    }

    public function update(ClassRoomRequest $request, ClassRoom $classRoom): RedirectResponse
    {
        return $this->classRoomService->save($request, $classRoom);
    }

    public function destroy(ClassRoom $classRoom): JsonResponse
    {
        $response = $this->classRoomService->delete($classRoom);

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
