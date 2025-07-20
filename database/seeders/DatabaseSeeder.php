<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        $permissions = [
            'dashboard',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-create',
            'permission-create',
            'class-room-list',
            'class-room-create',
            'class-room-edit',
            'class-room-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'interval-point-list',
            'interval-point-create',
            'interval-point-edit',
            'interval-point-delete',
        ];
       

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }

        $user = User::create([
            'name' => 'Administrator',
            'username' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $role = Role::create(['name' => 'Superadmin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $this->call(ClassRoomSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(TeacherSeeder::class);
    }
}
