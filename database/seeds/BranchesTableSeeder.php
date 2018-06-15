<?php

use App\Branch;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'code' => 'bac',
            'name' => 'bacolod',
            'added_by' => 1
        ]);
        Branch::create([
            'code' => 'ceb',
            'name' => 'cebu',
            'added_by' => 1
        ]);
        Branch::create([
            'code' => 'dav',
            'name' => 'davao',
            'added_by' => 1
        ]);
        Branch::create([
            'code' => 'ilo',
            'name' => 'ilo-ilo',
            'added_by' => 1
        ]);
        Branch::create([
            'code' => 'mkt',
            'name' => 'makati',
            'added_by' => 1
        ]);
    }
}
