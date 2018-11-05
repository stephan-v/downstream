<?php

namespace App\Providers;

use App\Domain\Ssh\SSH;
use Illuminate\Support\ServiceProvider;

class SSHServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SSH::class, function () {
            return new SSH();
        });
    }
}
