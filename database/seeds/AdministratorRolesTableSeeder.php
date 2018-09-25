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
            'administrator_id' => 1, // esme
            'role_id' => 1,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 2, // ryan
            'role_id' => 2,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 3, // angel
            'role_id' => 3,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 4, // mark
            'role_id' => 8,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 5, // susan
            'role_id' => 9,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 6, // pia
            'role_id' => 6,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 7, // samiel
            'role_id' => 3,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 8, // sarah
            'role_id' => 8,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 9, // marie
            'role_id' => 9,
            'assigned_by' => 1,
        ]);

        \App\AdministratorRole::create([
            'administrator_id' => 10, // conan
            'role_id' => 6,
            'assigned_by' => 1,
        ]);
    }
}
