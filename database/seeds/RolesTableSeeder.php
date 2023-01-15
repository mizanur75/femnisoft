<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
        ]);
        
        DB::table('roles')->insert([
            'name' => 'Agent',
        ]);

        DB::table('roles')->insert([
            'name' => 'Doctor',
        ]);
        DB::table('roles')->insert([
            'name' => 'Pharmacy',
        ]);
        DB::table('roles')->insert([
            'name' => 'Pharma',
        ]);
        DB::table('roles')->insert([
            'name' => 'User',
        ]);
    }
}
