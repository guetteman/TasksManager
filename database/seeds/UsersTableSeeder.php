<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the UsersTable seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create([
          'first_name' => 'admin',
          'last_name' => 'admin',
          'email' => 'admin@gmail.com',
          'password' => app('hash')->make('admin'),
      ]);
    }
}
