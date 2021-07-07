<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('categories')->insert(array(
            0 =>
                array(
                    'id' => '1',
                    'category_name' => 'none'
                ),
            1 =>
                array(
                    'id' => '2',
                    'category_name' => 'personal'
                ),
            2 =>
                array(
                    'id' => '3',
                    'category_name' => 'job'
                ),
            3 =>
                array(
                    'id' => '4',
                    'category_name' => 'tasks'
                )
        ));

    }
}