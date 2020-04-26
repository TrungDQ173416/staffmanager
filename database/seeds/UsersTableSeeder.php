<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'      =>  'admin',
            'name'      =>  'admin',
            'email'     =>  'admin@gmail.com',
            'password'  =>  '123456'
        ]);

        $user = User::first();
        $user->assignRole('super_admin');
    }
}
