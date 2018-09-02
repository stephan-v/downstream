<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FixedCommandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertCloneRepositoryScript();
        $this->insertComposerInstallScript();
        $this->insertCleanOldReleasesScript();
    }

    /**
     * Clone the github repository.
     */
    private function insertCloneRepositoryScript()
    {
        // Clone repository script.
        DB::table('fixed_commands')->insert([
            'name' => 'Clone repository',
            'script' => serialize([
                'mkdir -p {{ $release }}',
                'git clone --depth 1 {{ $repository }} {{ $release }}',
                'exit'
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Install necessary composer dependencies.
     */
    private function insertComposerInstallScript()
    {
        // Composer install script.
        DB::table('fixed_commands')->insert([
            'name' => 'Composer install',
            'script' => serialize([
                'cd {{ $release }}',
                'composer install -o --no-interaction --prefer-dist'
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Clean the old releases from the server.
     */
    private function insertCleanOldReleasesScript()
    {
        // Clean old releases script.
        DB::table('fixed_commands')->insert([
            'name' => 'Clean old releases',
            'script' => serialize([
                'ln -snf {{ $release }} {{ $symlink }}',
                'cd {{ $releases }} && ls -t | tail -n +6 | xargs rm -rf'
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
