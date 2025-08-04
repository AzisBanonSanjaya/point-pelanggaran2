<?php

namespace App\Imports;


use App\Models\User;
use App\Models\MasterData\ClassRoom;
use App\Models\UserParent;
use Auth;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\Permission\Models\Role;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
                $dateOfBirth = null;
                if (!empty($row['tgl_lahir'])) {
                    try {
                        $dateOfBirth = Date::excelToDateTimeObject($row['tgl_lahir'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        try {
                            $dateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $row['tgl_lahir'])->format('Y-m-d');
                        } catch (\Exception $e) {
                            $dateOfBirth = null;
                        }
                    }
                }
                $user = User::create([
                    'name' => $row['name'],
                    'username' => $row['nis'],
                    'email' => $row['email'],
                    'phone_number' => $row['nomor_handphone'],
                    'date_of_birth' => $dateOfBirth,
                    'password' => bcrypt('password'),
                    'class_room_id' => $classRoom->id,
                ]);

                if($row['name_orang_tua'] && $row['email_orang_tua']){
                    UserParent::where('user_id', $user->id)->delete();
                    UserParent::create([
                        'user_id' => $user->id,
                        'name' => $row['name_orang_tua'],
                        'email' => $row['email_orang_tua'],
                    ]);
                }

                
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
