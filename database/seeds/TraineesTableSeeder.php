<?php

use Illuminate\Database\Seeder;

class TraineesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'username' => 'trainee',
            'email' => 'deguzman.esmeraldo@gmail.com',
            'password' => bcrypt('root'),
        ]);

        \App\Trainee::create([
            'user_id' => $user->id,
            'First_name' => 'Esmeraldo',
            'middle_name' => 'Barrios',
            'last_name' => 'de Guzman Jr',
            'mobile_number' => '+63965-286-5662',
            'rank' => 'cadet',
            'gender' => 'male',
            'address' => 'Multinationa village, Parañaque city.',
            'birth_date' => '1990-06-24',
        ]);
    }
}
