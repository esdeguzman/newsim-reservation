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
    }
}
