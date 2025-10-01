<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin', 
                'email' => 'admin@gmail.com', 
                'password' => 'password', 
                'id_role' => 1+-
                'wa'
            ]
            
        ];
   
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
