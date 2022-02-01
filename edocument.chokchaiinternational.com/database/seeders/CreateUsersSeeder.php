<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'is_users' => '1',
                'password' => bcrypt('1234'),
            ],
            [
                'name' => 'Users',
                'email' => 'users@gmail.com',
                'is_users' => '0',
                'password' => bcrypt('1234'),
            ]
        ];

        foreach ($user as $key => $value){
            User::create($value);
        }
    }
}
