<?php

use Illuminate\Database\Seeder;
use App\Priority;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the UsersTable seeds.
     *
     * @return void
     */
    public function run()
    {
      Priority::create([
          'name' => 'Low',
      ]);

      Priority::create([
          'name' => 'Medium',
      ]);

      Priority::create([
          'name' => 'High',
      ]);
    }
}
