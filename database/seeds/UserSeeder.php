<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            'name' => 'CKEY',
            'email' => 'ckey@email.com',
            'role_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('Admin@2065'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'role_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('Admin@2079'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Aggy',
            'email' => 'aggy@email.com',
            'role_id' => 2,
            'email_verified_at' => now(),
            'password' => bcrypt('Aggy@1060'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Elijah',
            'email' => 'elijah@email.com',
            'role_id' => 2,
            'email_verified_at' => now(),
            'password' => bcrypt('elijah@1050'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
