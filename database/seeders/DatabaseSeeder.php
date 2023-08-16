<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'role' => 'admin',
            'description' => "Admin",
        ]);
        DB::table('roles')->insert([
            'role' => 'customer',
            'description' => "Customer",
        ]);
        DB::table('roles')->insert([
            'role' => 'affiliate',
            'description' => "Affiliate ",
        ]);
        DB::table('roles')->insert([
            'role' => 'seller',
            'description' => "Seller ",
        ]);
        //users table seed
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => bcrypt(123123123),
            'is_admin' => "1",
            'is_approved' => "1",
            'role' => "admin",
            'email' => "admin@gmail.com",
        ]);
    }
}
