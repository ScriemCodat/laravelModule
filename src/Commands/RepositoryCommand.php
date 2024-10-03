<?php

namespace ScriemCodat\Repository\Commands;

use Illuminate\Console\Command;

class RepositoryCommand extends Command
{

    protected $signature = 'make:repo {name : Class (User, Product)}';

    protected $description = 'Create a repository class layer over Eloquent Model';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $name = $this->argument('name');

        if ( ! file_exists ( $path = base_path ( 'app/Repositories' ) ) )
            mkdir($path, 0777, true);

        if ( file_exists ( base_path ( "app/Repositories/{$name}Repository.php" ) ) ) {
            $this->error("Repository with that name ({$name}) already exists");
            exit(0);
        }

        self::createRepository($name);

        $this->info("Repository pattern implemented for model ". $name);
    
    }


    protected static function getStubs($type)
    {
        return file_get_contents("vendor/scriemcodat/repository/src/resources/$type.stub");
    }


    protected static function createRepository($name)
    {
        $template = str_replace( ['{{modelName}}'], [$name], self::GetStubs('Repository') );
        file_put_contents(base_path("app/Repositories/{$name}Repository.php"), $template);
    }


}
