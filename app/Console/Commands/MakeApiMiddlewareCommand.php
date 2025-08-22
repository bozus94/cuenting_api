<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\FileSystem\Filesystem;

class MakeApiMiddlewareCommand extends GeneratorCommand
{

    protected $name = 'make:api-middleware';
    protected $description = 'Create a new api Middleware';
    protected $type = "Api middleware";

    public function constructor(Filesystem $files)
    {
        parent::constructor($files);
    }

    protected function getStub()
    {
        return base_path('stubs/cuenting/api.middleware.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $apiVersion = $this->option('api-version');
        if ($apiVersion) {
            return $rootNamespace . "\\Http\\Api\\v.$apiVersion.\\Middlewares";
        }
        return $rootNamespace . "\\Http\\Api\\v1\\Middlewares";
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        return $class;
    }

    protected function getOptions()
    {
        return [
            ['api-version',  null, InputOption::VALUE_REQUIRED,  'Define version of api'],
        ];
    }
}
