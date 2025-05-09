<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'kelas-list',
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }

        $user = User::create([
            'name' => 'SMAN',
            'username' => 'SMAN',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin1234')
        ]);

        $role = Role::create(['name' => 'Superadmin']);

        $role = Role::create(['name' => 'Kesiswaan']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
