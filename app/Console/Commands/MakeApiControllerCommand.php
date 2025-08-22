<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class MakeApiControllerCommand extends GeneratorCommand
{
    protected $name = 'make:api-controller';
    protected $description = 'Create a new API controller';
    protected $type = 'API Controller';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        $base = base_path('stubs/cuenting');

        if ($this->option('invokable')) {
            return $base . '/api.controller.invokable.stub';
        }

        if ($this->option('model')) {
            return $base . '/api.controller.model.stub';
        }

        return $base . '/api.controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $apiVersion = $this->option('api-version');
        if ($apiVersion) {
            return  $rootNamespace . '\\Http\\Api\\V' . $apiVersion . '\\Controllers';
        }
        return $rootNamespace . '\\Http\\Api\\V1\\Controllers';
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        // Sustituye marcadores de modelo si se pasó --model
        $model = $this->option('model');
        if ($model) {
            $fqModel = str_starts_with($model, '\\') ? ltrim($model, '\\') : "App\\Models\\{$model}";
            $class = str_replace(
                ['DummyFullModel', 'DummyModel'],
                [$fqModel, class_basename($fqModel)],
                $class
            );
        } else {
            $class = str_replace(['DummyFullModel', 'DummyModel'], ['', ''], $class);
        }

        // Asegura sufijo "Controller"
        $class = preg_replace_callback('/class\s+([A-Za-z0-9_]+)/', function ($m) {
            return str_ends_with($m[1], 'Controller') ? $m[0] : 'class ' . $m[1] . 'Controller';
        }, $class);

        return $class;
    }

    protected function qualifyClass($name)
    {
        // Permite pedir "Expense" y forzar "ExpenseController"
        $name = preg_replace('/Controller$/', '', $name);
        return parent::qualifyClass($name . 'Controller');
    }

    protected function getOptions()
    {
        return [
            ['model',       null, InputOption::VALUE_REQUIRED,  'Bind a model into the controller'],
            ['api-version', null, InputOption::VALUE_REQUIRED,  'Define a version of api'],
            ['resource',    null, InputOption::VALUE_NONE,      'Generate a resourceful controller'],
            ['invokable',   null, InputOption::VALUE_NONE,      'Generate a single method __invoke controller'],
            ['force',       null, InputOption::VALUE_NONE,      'Overwrite existing files'],
        ];
    }
}
