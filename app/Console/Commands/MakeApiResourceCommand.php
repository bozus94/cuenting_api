<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class MakeApiResourceCommand extends GeneratorCommand
{
    protected $name = 'make:api-resource';
    protected $description = 'Create a new API Resource';
    protected $type = 'API Resource';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        $base = base_path('stubs/cuenting');
        return $this->option('collection')
            ? $base . '/api.resource.collection.stub'
            : $base . '/api.resource.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $apiVersion = $this->option('api-version');
        if ($apiVersion) {
            return  $rootNamespace . '\\Http\\Api\V' . $apiVersion . '\\Resources';
        }
        return $rootNamespace . '\\Http\\Api\\V1\\Resources';
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        // Asegura sufijo *Resource
        $class = preg_replace_callback('/class\s+([A-Za-z0-9_]+)/', function ($m) {
            return str_ends_with($m[1], 'Resource') ? $m[0] : 'class ' . $m[1] . 'Resource';
        }, $class);

        return $class;
    }

    protected function qualifyClass($name)
    {
        // Normaliza a *Resource
        $name = preg_replace('/Resource$/', '', $name);
        return parent::qualifyClass($name . 'Resource');
    }

    protected function getOptions()
    {
        return [
            ['collection',  null, InputOption::VALUE_NONE, 'Generate a resource collection'],
            ['api-version', null, InputOption::VALUE_NONE, 'Define version of api'],
            ['force',       null, InputOption::VALUE_NONE, 'Overwrite existing files'],
        ];
    }
}
