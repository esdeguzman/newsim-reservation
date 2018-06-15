<?php

use Illuminate\Database\Seeder;

class AdministratorRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\AdministratorRole::create([
            'administrator_id' => 1,
            'role_id' => 1,
            'assigned_by' => 1,
        ]);
    }
}
