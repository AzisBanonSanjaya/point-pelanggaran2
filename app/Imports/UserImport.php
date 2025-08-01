<?php

namespace App\Imports;


use App\Models\User;
use App\Models\MasterData\ClassRoom;
use Auth;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\Permission\Models\Role;
use Str;

class UserImport implements ToCollection, WithHeadingRow
{
    private $failedImports = [];
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
           foreach ($rows as $key => $row) {
                $classRoom = ClassRoom::where('code', $row['kelas'])->first();
                if (!$classRoom) {
                    $this->failedImports[] = $row['kelas'];
                    return;
                }
                $user = User::create([
                    'name' => $row['name'],
                    'username' => $row['nis'],
                    'email' => $row['email'],
                    'phone_number' => $row['nomor_handphone'],
                    'date_of_birth' => $row['tgl_lahir'],
                    'password' => bcrypt('password'),
                    'class_room_id' => $classRoom->id,
                ]);
                $role = Role::where('name', 'user')->first();
                $user->assignRole([$role->id]);
           }
            
        } catch (\Exception $e) {
            Log::error('Error importing user: ' . $e->getMessage());
        }
    }

    public function getFailedImports()
    {
        return $this->failedImports;
    }

}
