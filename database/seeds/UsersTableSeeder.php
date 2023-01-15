<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'phone' => '01710472020',
            'gender' => 0,
            'status' => 1,
            'payment' => 1,
            'amount' => 1000,
            'room' => "https://meet.jit.si/".str_random(20),
            'password' => bcrypt('11111111'),
        ]);
        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'Agent',
            'slug' => 'agent',
            'username' => 'agent',
            'email' => 'agent@email.com',
            'phone' => '01880162661',
            'gender' => 0,
            'status' => 1,
            'payment' => 1,
            'amount' => 1000,
            'room' => "https://meet.jit.si/".str_random(20),
            'password' => bcrypt('22222222'),
        ]);
        DB::table('users')->insert([
            'role_id' => 3,
            'name' => 'Doctor',
            'slug' => 'doctor',
            'username' => 'doctor',
            'email' => 'doctor@email.com',
            'phone' => '01880162662',
            'gender' => 0,
            'status' => 1,
            'payment' => 1,
            'amount' => 1000,
            'room' => "https://meet.jit.si/".str_random(20),
            'password' => bcrypt('33333333'),
        ]);
        DB::table('users')->insert([
            'role_id' => 4,
            'name' => 'Pharmacy',
            'slug' => 'pharmacy',
            'username' => 'pharmacy',
            'email' => 'pharmacy@email.com',
            'phone' => '01880162664',
            'gender' => 0,
            'status' => 1,
            'payment' => 1,
            'amount' => 1000,
            'room' => "https://meet.jit.si/".str_random(20),
            'password' => bcrypt('44444444'),
        ]);
        DB::table('users')->insert([
            'role_id' => 5,
            'name' => 'Pharma',
            'slug' => 'pharma',
            'username' => 'pharma',
            'email' => 'pharma@email.com',
            'phone' => '01880162692',
            'gender' => 0,
            'status' => 1,
            'payment' => 1,
            'amount' => 1000,
            'room' => "https://meet.jit.si/".str_random(20),
            'password' => bcrypt('55555555'),
        ]);
        DB::table('users')->insert([
            'role_id' => 6,
            'name' => 'User',
            'slug' => 'user',
            'username' => 'user',
            'email' => 'user@email.com',
            'phone' => '01880162662',
            'gender' => 0,
            'status' => 1,
            'payment' => 1,
            'amount' => 1000,
            'room' => "https://meet.jit.si/".str_random(20),
            'password' => bcrypt('66666666'),
        ]);
    }
}
