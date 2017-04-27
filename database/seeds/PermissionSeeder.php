<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $permissions = [
            [
                'name' => 'admin access'
            ],
            [
                'name' => 'moderator access'
            ]
        ];

        $roles = [
            [
                'name' => 'adminstrator'
            ],
            [
                'name' => 'moderator'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
