<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Models\MasterData\ClassRoom;
use App\Models\User;
use App\Services\UserManagement\UserService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    private Role $roles;
    private Permission $permission;
    private User $user;
    private UserService $userService;


    public function __construct(Role $roles,Permission $permission, User $user, UserService $userService)
    {
        $this->roles = $roles;
        $this->permission = $permission;
        $this->user = $user;
        $this->userService = $userService;
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View|Factory
    {
        $roles  = $this->roles->with(['permissions'])->get(['id','name']);
        $permissions = $this->permission->orderBy('id')->get(['id','name']);
        $classRooms = ClassRoom::get(['id','code']);
        return view('backEnd.userManagement.user.index', compact('roles','permissions', 'classRooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request): RedirectResponse
    {
        return $this->userService->save($request);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user): JsonResponse
    {
        if(!empty($user)){
            $roles = $this->roles->where('id', '!=', 1)->get();
            $idRole = [];
            if($user->roles->isNotEmpty()){
                foreach($user->roles as $user_role){
                    $idRole[] = $user_role->id;
                }
            }
            if($roles->isNotEmpty()){
                foreach($roles as $key => $role){
                    $roles[$key]->selected = '';
                    if(in_array($role->id, $idRole)){
                        $roles[$key]->selected = 'selected';
                    }
                }
            }

            $classRooms = ClassRoom::get(['id','code']);
            
            if($classRooms->isNotEmpty()){
                $classRooms->each(function ($classRoom) use ($user) {
                    $classRoom->selected = ($classRoom->id === $user->class_room_id) ? 'selected' : '';
                });
            }

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diambil.',
                'data'    => $user,
                'roles'   => $roles,
                'classRooms'   => $classRooms,
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ada.',
                'data'    => [],
                'roles'   => [],
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        return $this->userService->save($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): JsonResponse
    {
        $service = $this->userService->delete($user);
        if($service){
            return response()->json([
                'message' => 'Data berhasil dihapus.',
                'status' => true,
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Gagal Di hapus.',
                'status' => false,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function fetchDataTable(Request $request): JsonResponse
    {
        $columns = [
            'id', 'name', 'email', 'created_at','username','date_of_birth','phone_number'
        ];

        $searchValue = $request->input('search.value');
        $orderColumn = $columns[$request->input('order.0.column', 0)];
        $orderDirection = $request->input('order.0.dir', 'asc');
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $no = $start + 1;
        $query = $this->user->with('roles')->select($columns);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('email', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalData = $query->count();
        $users = $query
            ->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = $users->map(function ($user) use (&$no) {
            return [
                'no' => $no++,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role_name' => $user->roles->pluck('name')->implode(', '),
                'date_of_birth' => $user->formatted_date_of_birth,
                'phone_number' => $user->phone_number,
                'actions' => '
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-gear-fill"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item edit" href="#" data-url-update="' . route('user.update', $user->id) . '" data-url="' . route('user.show', $user->id) . '">
                                <em class="bi bi-pencil-fill open-card-option"></em> Edit
                            </a>
                            <a class="dropdown-item delete" href="#" data-url-destroy="' . route('user.destroy', $user->id) . '">
                                <em class="bi bi-trash-fill close-card"></em> Delete
                            </a>
                        </div>
                    </div>',
            ];
        })->toArray();


        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data
        ];

        return response()->json($jsonData, JsonResponse::HTTP_OK);
    }

}
