<?php

use Illuminate\Database\Seeder;
use App\Directory;

class DirectoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $directory = new Directory;
        $directory -> id = 1;
        $directory ->user_id = 0;
        $directory -> parent = 0;
        $directory -> name = '/';
        $directory -> path = '/';
        $directory -> save();
    }
}
