<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('admin'),
            'userId' => Str::random(10),
            'nation' => Str::random(10),
            'gender' => 'male',
            'site_id' => null,
            'job_id' => null,
            'role_id' => 4,
            'approved'  => 1
        ]);
    }
}
