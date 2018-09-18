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
        $this->insertComposerInstallScript();
        $this->insertCleanOldReleasesScript();
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
            'icon' => 'clone',
            'script' => serialize([
                'mkdir -p {{ $release }}',
                'git clone --depth 1 {{ $repository }} {{ $release }}',
                'exit'
            ]),
            'custom' => false,
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
        DB::table('actions')->insert([
            'name' => 'Composer install',
            'description' => 'Run the composer installer',
            'icon' => 'composer',
            'script' => serialize([
                'cd {{ $release }}',
                'composer install -o --no-interaction --prefer-dist'
            ]),
            'custom' => false,
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
        DB::table('actions')->insert([
            'name' => 'Clean old releases',
            'description' => 'Clean previous deployments except the first 5',
            'icon' => 'clean',
            'script' => serialize([
                'ln -snf {{ $release }} {{ $symlink }}',
                'cd {{ $releases }} && ls -t | tail -n +6 | xargs rm -rf'
            ]),
            'custom' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
