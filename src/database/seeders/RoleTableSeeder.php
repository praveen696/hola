<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(
            [
                'name' => 'Admin',
                'description' => 'Admin',
            ]
        );
        Role::firstOrCreate(
            [
                'name' => 'PAGE_1',
                'description' => 'PAGE_1',
            ]
        );
        Role::firstOrCreate(
            [
                'name' => 'PAGE_2',
                'description' => 'PAGE_2',
            ]
        );
    }
}
