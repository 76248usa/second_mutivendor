<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ADMIN
        DB::table('users')->insert([
            //admin
            ['name' => 'Admin',
             'username' => 'admin',
             'email' => 'admin@gmail.com',
             'role' => 'admin',
             'password' => Hash::make('111'),
             'status' => 'active',
            
        ],
        //VENDOR
        ['name' => 'Elle Vendor',
             'username' => 'vendor',
             'email' => 'vendor@gmail.com',
             'role' => 'vendor',
             'password' => Hash::make('111'),
             'status' => 'active',
            
        ],
         //USER
        ['name' => 'User',
             'username' => 'user',
             'email' => 'user@gmail.com',
             'role' => 'user',
             'password' => Hash::make('111'),
             'status' => 'active',
            
        ],

    ]);

       
    }
}
