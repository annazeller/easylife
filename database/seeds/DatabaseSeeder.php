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
            'name' => "testuser",
            'email' => "test@user.de",
            'password' => 123456,
        ]);

        DB::table('todos')->insert([
            'userId' => 1,
            'title' => str_random(10),
            'description' => str_random(10),
            'location' => str_random(10),
            'priority' => 1,
            'duration' => 10,
        ]);

        DB::table('todos')->insert([
            'userId' => 1,
            'title' => str_random(10),
            'description' => str_random(10),
            'location' => str_random(10),
            'priority' => 2,
            'duration' => 10,
        ]);

        DB::table('todos')->insert([
            'userId' => 1,
            'title' => str_random(10),
            'description' => str_random(10),
            'location' => str_random(10),
            'priority' => 3,
            'duration' => 10,
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
