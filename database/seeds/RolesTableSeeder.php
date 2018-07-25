<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'developer',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'system admin',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'accounting officer',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'confirm reservation',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'cancel reservation',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'registration officer',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'confirm registration',
            'added_by' => 1,
        ]);

        Role::create([
            'name' => 'training officer',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'marketing officer',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'approve admin request',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'deny admin request',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'reactivate admin account',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'deactivate admin account',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'update course',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'update branch course',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'add course',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'delete course',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'add branch course',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'delete branch course',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'set original price',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'amend original price',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'update discount',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'add schedule',
            'added_by' => 1
        ]);

        Role::create([
            'name' => 'update schedule',
            'added_by' => 1
        ]);
    }
}
