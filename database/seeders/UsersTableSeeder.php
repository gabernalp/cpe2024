<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@icbf.gov.co',
                'password'       => bcrypt('upebuKTmv8X5'),
                'remember_token' => null,
                'phone'          => '',
                'document'       => 899999239,
            ],
        ];

        User::insert($users);
    }
}
