<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker::create('id_ID');

        // Pastikan role "User" sudah ada atau buat
        $role = Role::firstOrCreate(['name' => 'Teacher']);

        // Ambil semua permission
        $permissions = Permission::where('name', 'dashboard')->pluck('id', 'id')->all();

        // Sync semua permission ke role User (opsional, bisa disesuaikan)
        $role->syncPermissions($permissions);

        // Buat 10 user dengan faker dan assign role "User"
        for ($i = 0; $i < 30; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => 	 $faker->numberBetween(100000, 999999),
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'date_of_birth'  => $faker->dateTimeBetween('-55 years', '-18 years')->format('Y-m-d'),
                'phone_number' => $faker->phoneNumber,
            ]);

            $user->assignRole($role);
        }
    }
}
