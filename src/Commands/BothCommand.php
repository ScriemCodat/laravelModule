<?php

namespace ScriemCodat\Repository\Commands;

use Illuminate\Console\Command;

class BothCommand extends Command
{

    protected $signature = 'make:logic {name : ServiceName (ex: ProductSearchService)}';

    protected $description = 'Create a repository  and a service';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {


        $name = $this->argument('name');

        //SERVICE
        if ( ! file_exists ( $path = base_path ( 'app/Services' ) ) )
            mkdir($path, 0777, true);

        if ( file_exists ( base_path ( "app/Services/{$name}Service.php" ) ) ) {
            $this->error("Service with that name ({$name}) already exists");
            exit(0);
        }

        self::createService($name);

        $this->info("Service pattern implemented for model ". $name);

        //REPO
        if ( ! file_exists ( $path = base_path ( 'app/Repositories' ) ) )
            mkdir($path, 0777, true);

        if ( file_exists ( base_path ( "app/Repositories/{$name}Repository.php" ) ) ) {
            $this->error("Repository with that name ({$name}) already exists");
            exit(0);
        }

        self::createRepository($name);

        $this->info("Repository pattern implemented for model ". $name);

        //Interface
        if ( ! file_exists ( $path = base_path ( 'app/Interfaces' ) ) )
            mkdir($path, 0777, true);

        if ( file_exists ( base_path ( "app/Interfaces/{$name}Interface.php" ) ) ) {
            $this->error("Interface with that name ({$name}) already exists");
            exit(0);
        }

        self::createInterface($name);

        $this->info("Interface pattern implemented");


    }


    protected static function getStubs($type)
    {
        return file_get_contents("vendor/scriemcodat/repository/src/resources/$type.stub");
    }


    protected static function createService($name)
    {
        $template = str_replace( ['{{serviceName}}'], [$name], self::GetStubs('Service') );
        file_put_contents(base_path("app/Services/{$name}Service.php"), $template);
    }

    protected static function createRepository($name)
    {
        $template = str_replace( ['{{modelName}}'], [$name], self::GetStubs('Repository') );
        file_put_contents(base_path("app/Repositories/{$name}Repository.php"), $template);
    }
    protected static function createInterface($name)
    {
        $template = str_replace( ['{{modelName}}'], [$name], self::GetStubs('Interface') );
        file_put_contents(base_path("app/Interfaces/{$name}Interface.php"), $template);
    }


}
