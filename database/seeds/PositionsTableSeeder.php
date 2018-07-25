<?php

use App\Position;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'it programmer',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'chief it officer',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'it support',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'chief accounting officer',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'accounting staff',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'chief registration officer',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'registration staff',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'chief training officer',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'training staff',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'marketing staff',
            'added_by' => 1
        ]);

        Position::create([
            'name' => 'chief marketing officer',
            'added_by' => 1
        ]);
    }
}
