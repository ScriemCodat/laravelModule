<?php

namespace ScriemCodat\Repository;

use Illuminate\Support\ServiceProvider;
use ScriemCodat\Repository\Commands\CreateCommand;
use ScriemCodat\Repository\Commands\RepositoryCommand ;
use ScriemCodat\Repository\Commands\ServiceCommand ;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            RepositoryCommand::class,
            ServiceCommand::class,
            CreateCommand::class,
        ]);
    }
}
