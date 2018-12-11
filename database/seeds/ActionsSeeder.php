<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertCloneRepositoryScript();
    }

    /**
     * Clone the github repository.
     */
    private function insertCloneRepositoryScript()
    {
        // Clone repository script.
        DB::table('actions')->insert([
            'name' => 'Clone repository',
            'description' => 'Clone a Github repository',
            'icon' => 'github',
            'script' => serialize([
                'mkdir -p {{ $release }}',
                'git clone --depth 1 {{ $repository }} {{ $release }}',
                'exit'
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
