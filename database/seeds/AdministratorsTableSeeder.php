<?php

use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'username' => 'esme',
            'email' => 'devyops@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 5,
            'position_id' => 1,
            'department_id' => 1,
            'employee_id' => '0624853',
            'full_name' => 'Esmeraldo Barrios de Guzman Jr',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'rmmilante',
            'email' => 'rmmilante@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 5,
            'position_id' => 2,
            'department_id' => 1,
            'employee_id' => '0829853',
            'full_name' => 'Ryan Milante',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'angel',
            'email' => 'angel@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 5,
            'position_id' => 3,
            'department_id' => 5,
            'employee_id' => '889754',
            'full_name' => 'Angel Simson',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'mark',
            'email' => 'mark@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 5,
            'position_id' => 5,
            'department_id' => 2,
            'employee_id' => '885754',
            'full_name' => 'Mark Bueno',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'susan',
            'email' => 'susan@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 5,
            'position_id' => 4,
            'department_id' => 4,
            'employee_id' => '336589',
            'full_name' => 'Susan Conan',
            'added_by' => 1,
            'status' => 'active',
        ]);
// bacolod
        $user = \App\User::create([
            'username' => 'monette',
            'email' => 'monette@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1,
            'position_id' => 3,
            'department_id' => 5,
            'employee_id' => '55889',
            'full_name' => 'Monette Garcia',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'manny',
            'email' => 'manny@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1,
            'position_id' => 5,
            'department_id' => 2,
            'employee_id' => '123548',
            'full_name' => 'Manny Toledo',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'norman',
            'email' => 'norman@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1,
            'position_id' => 4,
            'department_id' => 4,
            'employee_id' => '999845',
            'full_name' => 'Norman Quez',
            'added_by' => 1,
            'status' => 'active',
        ]);
    }
}
