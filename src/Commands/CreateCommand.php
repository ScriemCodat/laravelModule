<?php

namespace ScriemCodat\Repository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateCommand extends Command
{

    private $types = [
       'controller',
        'resource',
        'request',
        'model',
        'observer',
        'service',

    ];
    protected $name;
    protected $signature = 'create:module {name : ModelName (ex: Company)}';

    protected $description = 'Create a Module Directory with Service, Repository and Interface';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $this->name = $this->argument('name');

        $this->createFolders();



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
            }else{
                $this->error("Module with that name ({$this->name}) already exists");
               continue;
            }
        }
        $this->implementInterface();
        \Artisan::call('make:factory', ['name' => ucfirst($this->name)]);
        \Artisan::call('make:migration', ['name' => 'create'. Str::plural($this->name).'_table']);

    }

    private function implementInterface()
    {
        if ( ! file_exists ( $path = base_path ( "app/Repository/" ) ) ) {
            mkdir($path, 0777, true);
        }
        $template = self::GetStubs('readinterface') ;
        if ( !file_exists ( base_path ( "app/Repository/ReadRepositoryInterface.php" ) ) ) {
            file_put_contents(base_path("app/Repository/ReadRepositoryInterface.php"), $template);
        }
        $template =  self::GetStubs('writeinterface') ;

        if ( !file_exists ( base_path ( "app/Repository/WriteRepositoryInterface.php" ) ) ) {
            file_put_contents(base_path("app/Repository/WriteRepositoryInterface.php"), $template);
        }

        $template =  self::GetStubs('repository') ;
        if ( !file_exists ( base_path ( "app/Repository/Repository.php" ) ) ) {
            file_put_contents(base_path("app/Repository/Repository.php"), $template);
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
