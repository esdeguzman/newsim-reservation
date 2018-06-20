<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BranchesTableSeeder::class);
         $this->call(PositionsTableSeeder::class);
         $this->call(DeparmentsTableSeeder::class);
         $this->call(AdministratorsTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(AdministratorRolesTableSeeder::class);
         $this->call(TraineesTableSeeder::class);
         $this->call(CoursesTableSeeder::class);
    }
}
