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
            'branch_id' => 5, // makati
            'position_id' => 1, // developer
            'department_id' => 1, // it
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
            'branch_id' => 5, // makati
            'position_id' => 2, // chief it officer
            'department_id' => 1, // it
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
            'branch_id' => 5, // makati
            'position_id' => 4, // chief accounting officer
            'department_id' => 5, // accounting
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
            'branch_id' => 5, // makati
            'position_id' => 8, // chief training officer 
            'department_id' => 2, // training
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
            'branch_id' => 5, // makati
            'position_id' => 11, // chief marketing officer
            'department_id' => 3, // marketing
            'employee_id' => '336589',
            'full_name' => 'Susan Conan',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'pia',
            'email' => 'pia@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 5, // makati
            'position_id' => 6, // chief registration officer
            'department_id' => 4, // registration
            'employee_id' => '336349',
            'full_name' => 'Pia Samaniego',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'samiel',
            'email' => 'samiel@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1, // bacolod
            'position_id' => 4, // chief accounting officer
            'department_id' => 5, // accounting
            'employee_id' => '881254',
            'full_name' => 'Samiel Maloto',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'sarah',
            'email' => 'sarah@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1, // bacolod
            'position_id' => 8, // chief training officer 
            'department_id' => 2, // training
            'employee_id' => '926754',
            'full_name' => 'Sarah Cueta',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'marie',
            'email' => 'marie@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1, // bacolod
            'position_id' => 11, // chief marketing officer
            'department_id' => 3, // marketing
            'employee_id' => '566589',
            'full_name' => 'Marie Umali',
            'added_by' => 1,
            'status' => 'active',
        ]);

        $user = \App\User::create([
            'username' => 'conan',
            'email' => 'conan@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Administrator::create([
            'user_id' => $user->id,
            'branch_id' => 1, // bacolod
            'position_id' => 6, // chief registration officer
            'department_id' => 4, // registration
            'employee_id' => '338649',
            'full_name' => 'Conan Phil',
            'added_by' => 1,
            'status' => 'active',
        ]);
    }
}
