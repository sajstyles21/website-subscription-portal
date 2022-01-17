<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@yopmail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@yopmail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('websites')->insert([
            'name' => Str::random(10),
        ]);

        DB::table('websites')->insert([
            'name' => Str::random(10),
        ]);
    }
}
