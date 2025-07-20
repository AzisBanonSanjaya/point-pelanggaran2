<?php

namespace Database\Seeders;

use App\Models\MasterData\ClassRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classRooms = [
            [
                'name' => 'Kelas X (10)',
                'user_id' => 32,
                'major' => 'IPA',
                'code' => 'X-IPA',
            ],
            [
                'name' => 'Kelas XI (11)',
                'user_id' => 32,
                'major' => 'IPA',
                'code' => 'XI-IPA',
            ],
            [
                'name' => 'Kelas XII (12)',
                'user_id' => 32,
                'major' => 'IPA',
                'code' => 'XII-IPA',
            ],
            [
                'name' => 'Kelas X (10)',
                'user_id' => 32,
                'major' => 'IPS',
                'code' => 'X-IPS',
            ],
            [
                'name' => 'Kelas XI (11)',
                'user_id' => 32,
                'major' => 'IPS',
                'code' => 'XI-IPS',
            ],
            [
                'name' => 'Kelas XII (12)',
                'user_id' => 32,
                'major' => 'IPS',
                'code' => 'XII-IPS',
            ]
        ];

        ClassRoom::truncate();
        ClassRoom::insert($classRooms);
    }
}
