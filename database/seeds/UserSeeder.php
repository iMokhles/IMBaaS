<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'imokhls@aol.fr',
                'emailVerified' => true,
                'password' => bcrypt("123456"),
            ],
            [
                'name' => 'Admin 2',
                'username' => 'admin2',
                'email' => 'mokhleshussien@aol.fr',
                'emailVerified' => true,
                'password' => bcrypt("123456"),
            ]
        ];

        foreach ($users as $user) {
            $userCreated = User::create($user);
            $userCreated->assignRole('adminstrator');
        }

       factory(App\User::class, 300)->create();
    }
}
