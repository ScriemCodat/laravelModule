<?php

namespace ScriemCodat\Repository\Commands;

use Illuminate\Console\Command;

class CreateCommand extends Command
{

    private $types = [
        'controller',
        'interface',
        'migration',
        'model',
        'observer',
        'repository',
        'service',

    ];
    protected $name;
    protected $signature = 'create:all {name : ModelName (ex: Company)}';

    protected $description = 'Create a Module Directory with Service, Repository and Interface';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $this->name = $this->argument('name');

        $this->createFolders();
        return;

        //SERVICE
        if ( ! file_exists ( $path = base_path ( "app/Modules/{$name}/Services" ) ) )
            mkdir($path, 0777, true);



        self::createService($name);

      /*  $this->info("Service pattern implemented for model ". $name);

        //REPO
        if ( ! file_exists ( $path = base_path ( "app/Modules/{$name}/Repositories" ) ) )
            mkdir($path, 0777, true);

        if ( file_exists ( base_path ( "app/Modules/{$name}/Repositories/{$name}Repository.php" ) ) ) {
            $this->error("Repository with that name ({$name}) already exists");
            exit(0);
        }*/

       /* self::createRepository($name);

        $this->info("Repository pattern implemented for model ". $name);

        //Interface
        if ( ! file_exists ( $path = base_path ( "app/Modules/{$name}/Interfaces" ) ) )
            mkdir($path, 0777, true);

        if ( file_exists ( base_path ( "app/Modules/{$name}/Interfaces/{$name}Interface.php" ) ) ) {
            $this->error("Interface with that name ({$name}) already exists");
            exit(0);
        }

        self::createInterface($name);*/

        $this->info("Interface pattern implemented");


    }

    private function createFolders()
    {
        foreach ($this->types as $type) {
            if ( ! file_exists ( $path = base_path ( "app/Modules/".ucfirst($this->name)."/".ucfirst($type) ) ) ) {
                mkdir($path, 0777, true);
            }


            if ( !file_exists ( base_path ( "app/Modules/".ucfirst($this->name)."/".ucfirst($type)."/".ucfirst($this->name).ucfirst($type).".php" ) ) ) {
                $this->implement($type);
            }
        }
    }


    protected static function getStubs($type)
    {
        return file_get_contents("vendor/scriemcodat/repository/src/resources/$type.stub");
    }


    private  function implement($type)
    {
        $search = [
            '{{modelName}}',
            '{{ namespace }}',
            '{{ namespacedModel }}',
            '{{ rootNamespace }}',
            '{{ class }}',
            '{{ storeRequest }}',
            '{{ model }}',
            '{{ modelVariable }}',
            '{{ updateRequest }}',
        ];
        $replace = [
            ucfirst($this->name),
            'App\Modules\\'.ucfirst($this->name).'\\'.ucfirst($type),
            'App\Modules\\'.ucfirst($this->name).'\\Model\\'.ucfirst($this->name),
            'App\\',
            ucfirst($this->name).(ucfirst($type) != 'Model' ? ucfirst($type) : null),
            ucfirst($this->name).'StoreRequest',
            ucfirst($this->name),
            strtolower($this->name),
            ucfirst($this->name).'UpdateRequest',
        ];
        $template = str_replace( $search, $replace, self::GetStubs($type) );
        file_put_contents(base_path ( "app/Modules/".ucfirst($this->name)."/".ucfirst($type)."/".ucfirst($this->name).(ucfirst($type) != 'Model' ? ucfirst($type) : null).".php" ), $template);
    }

    protected static function createRepository($name)
    {
        $template = str_replace( ['{{modelName}}'], [$name], self::GetStubs('repository') );
        file_put_contents(base_path("app/Repositories/{$name}Repository.php"), $template);
    }
    protected static function createInterface($name)
    {
        $template = str_replace( ['{{modelName}}'], [$name], self::GetStubs('interface') );
        file_put_contents(base_path("app/Interfaces/{$name}Interface.php"), $template);
    }


}
