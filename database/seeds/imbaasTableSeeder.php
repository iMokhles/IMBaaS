<?php

use Illuminate\Database\Seeder;


class imbaasTableSeeder extends Seeder {
    public function run()
    {
        
        DB::table('classes')->insert([
            
            [
                'id' => 1,
                'name' => 'Users',
                'table_name' => 'users',
                'created_at' => '2017-06-30 01:31:45',
                'updated_at' => '2017-06-30 01:31:45',
            ],

            [
                'id' => 2,
                'name' => 'Analytics',
                'table_name' => 'analytics',
                'created_at' => '2017-06-30 01:31:52',
                'updated_at' => '2017-06-30 01:31:52',
            ],

            [
                'id' => 3,
                'name' => 'Files',
                'table_name' => 'files',
                'created_at' => '2017-06-30 01:41:16',
                'updated_at' => '2017-06-30 01:41:16',
            ],

            [
                'id' => 4,
                'name' => 'Installations',
                'table_name' => 'installations',
                'created_at' => '2017-06-30 01:41:30',
                'updated_at' => '2017-06-30 01:41:30',
            ],

            [
                'id' => 5,
                'name' => 'Pushs',
                'table_name' => 'pushs',
                'created_at' => '2017-06-30 01:41:42',
                'updated_at' => '2017-06-30 01:41:53',
            ],

            [
                'id' => 6,
                'name' => 'Roles',
                'table_name' => 'roles',
                'created_at' => '2017-06-30 01:42:01',
                'updated_at' => '2017-06-30 01:42:01',
            ],

            [
                'id' => 7,
                'name' => 'Sessions',
                'table_name' => 'sessions',
                'created_at' => '2017-06-30 01:42:13',
                'updated_at' => '2017-06-30 01:42:13',
            ],

        ]);
//        DB::table('model_has_roles')->insert([
//
//            [
//                'role_id' => 1,
//                'model_id' => 1,
//                'model_type' => 'App\\User',
//            ],
//
//            [
//                'role_id' => 1,
//                'model_id' => 2,
//                'model_type' => 'App\\User',
//            ],
//
//        ]);
//        DB::table('permissions')->insert([
//
//            [
//                'id' => 1,
//                'name' => 'admin access',
//                'guard_name' => 'web',
//                'created_at' => '2017-06-30 11:37:46',
//                'updated_at' => '2017-06-30 11:37:46',
//            ],
//
//            [
//                'id' => 2,
//                'name' => 'moderator access',
//                'guard_name' => 'web',
//                'created_at' => '2017-06-30 11:37:46',
//                'updated_at' => '2017-06-30 11:37:46',
//            ],
//
//        ]);
//        DB::table('roles')->insert([
//
//            [
//                'id' => 1,
//                'name' => 'adminstrator',
//                'guard_name' => 'web',
//                'created_at' => '2017-06-30 11:37:46',
//                'updated_at' => '2017-06-30 11:37:46',
//            ],
//
//            [
//                'id' => 2,
//                'name' => 'moderator',
//                'guard_name' => 'web',
//                'created_at' => '2017-06-30 11:37:46',
//                'updated_at' => '2017-06-30 11:37:46',
//            ],
//
//            [
//                'id' => 3,
//                'name' => 'user',
//                'guard_name' => 'web',
//                'created_at' => '2017-06-30 11:37:46',
//                'updated_at' => '2017-06-30 11:37:46',
//            ],
//
//            [
//                'id' => 4,
//                'name' => 'customer',
//                'guard_name' => 'web',
//                'created_at' => '2017-06-30 11:37:46',
//                'updated_at' => '2017-06-30 11:37:46',
//            ],
//
//        ]);
        DB::table('sidemenu_classes')->insert([
            
            [
                'id' => 1,
                'name' => 'Users',
                'path' => '/users',
                'icon' => 'fa-users',
                'class_id' => 1,
                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 5,
                'depth' => 1,
                'created_at' => '2017-06-30 01:31:38',
                'updated_at' => '2017-06-30 01:35:04',
            ],

            [
                'id' => 2,
                'name' => 'Analytics',
                'path' => '/analytics',
                'icon' => 'fa-line-chart',
                'class_id' => 2,
                'parent_id' => NULL,
                'lft' => 2,
                'rgt' => 3,
                'depth' => 1,
                'created_at' => '2017-06-30 01:32:08',
                'updated_at' => '2017-06-30 01:35:04',
            ],

            [
                'id' => 3,
                'name' => 'Files',
                'path' => '/files',
                'icon' => 'fa-file',
                'class_id' => 3,
                'parent_id' => NULL,
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'created_at' => '2017-06-30 01:42:42',
                'updated_at' => '2017-06-30 01:42:42',
            ],

            [
                'id' => 4,
                'name' => 'Installations',
                'path' => '/installations',
                'icon' => 'fa-arrow-down',
                'class_id' => 4,
                'parent_id' => NULL,
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'created_at' => '2017-06-30 01:43:26',
                'updated_at' => '2017-06-30 01:43:26',
            ],

            [
                'id' => 5,
                'name' => 'Pushs',
                'path' => '/pushs',
                'icon' => 'fa-refresh',
                'class_id' => 5,
                'parent_id' => NULL,
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'created_at' => '2017-06-30 01:43:50',
                'updated_at' => '2017-06-30 01:43:50',
            ],

            [
                'id' => 6,
                'name' => 'Roles',
                'path' => '/roles',
                'icon' => 'fa-ban',
                'class_id' => 6,
                'parent_id' => NULL,
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'created_at' => '2017-06-30 01:44:09',
                'updated_at' => '2017-06-30 01:44:09',
            ],

            [
                'id' => 7,
                'name' => 'Sessions',
                'path' => '/sessions',
                'icon' => 'fa-lock',
                'class_id' => 7,
                'parent_id' => NULL,
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'created_at' => '2017-06-30 01:44:31',
                'updated_at' => '2017-06-30 01:44:31',
            ],

        ]);
    }
}