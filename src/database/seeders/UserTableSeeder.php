<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name', 'Admin')->first();

        $user = new User();
        $user->username = 'admin';
        $user->name = 'Admin';
        $user->password = Hash::make('adminpassword');
        $user->save();

        $user->roles()->attach($roleAdmin);
    }
}
