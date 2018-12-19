<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servers')->insert([
            'name' => 'BeerQuest',
            'path' => '/home/forge/downstream-test.nl',
            'ip_address' => '188.166.100.191',
            'user' => 'forge',
            'project_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('servers')->insert([
            'name' => 'Another Server',
            'path' => '/home/forge/downstream-test.nl',
            'ip_address' => '188.166.100.191',
            'user' => 'forge',
            'project_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
