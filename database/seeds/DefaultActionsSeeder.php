<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DefaultActionsSeeder extends Seeder
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
        $this->copyToActionsTable();
    }

    /**
     * Clone the github repository.
     */
    private function insertCloneRepositoryScript()
    {
        // Clone repository script.
        DB::table('default_actions')->insert([
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

    /**
     * Install necessary composer dependencies.
     */
    private function insertComposerInstallScript()
    {
        // Composer install script.
        DB::table('default_actions')->insert([
            'name' => 'Composer install',
            'description' => 'Run the composer installer',
            'icon' => 'php',
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
        DB::table('default_actions')->insert([
            'name' => 'Clean old releases',
            'description' => 'Clean previous deployments except the first 5',
            'icon' => 'clean',
            'script' => serialize([
                'ln -snf {{ $release }} {{ $symlink }}',
                'cd {{ $releases }} && ls -t | tail -n +6 | xargs rm -rf'
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Copy the default actions we just inserted over to the actions table.
     */
    private function copyToActionsTable()
    {
        $actions = DB::table('default_actions')->get();

        foreach ($actions as $action) {
            DB::table('actions')->insert(get_object_vars($action));
        }
    }
}
