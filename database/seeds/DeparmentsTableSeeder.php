<?php

use App\Department;
use Illuminate\Database\Seeder;

class DeparmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'code' => 'it',
            'name' => 'information technology',
            'added_by' => 1
        ]);
        Department::create([
            'code' => 'trng',
            'name' => 'training',
            'added_by' => 1
        ]);
        Department::create([
            'code' => 'mktng',
            'name' => 'marketing',
            'added_by' => 1
        ]);
        Department::create([
            'code' => 'reg',
            'name' => 'registration',
            'added_by' => 1
        ]);
        Department::create([
            'code' => 'acctng',
            'name' => 'accounting',
            'added_by' => 1
        ]);
    }
}
