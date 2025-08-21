<?php

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeRepositoryInterfaceCommand extends GeneratorCommand
{
    protected $name = 'make:repository-interface';
    protected $description = 'Create a new Repository interface for Cuenting';
    protected $type = 'Repository Interface';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        return base_path('stubs/cuenting/repository.interface.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $module = $this->option('module') ?: $this->getNameInput();
        return $rootNamespace . '\\Repositories\\' . $module . '\\Contracts';
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        // Asegurar sufijo RepositoryInterface
        $class = preg_replace_callback('/interface\s+([A-Za-z0-9_]+)/', function ($m) {
            $base = $m[1];
            if (!str_ends_with($base, 'RepositoryInterface')) {
                return 'interface ' . $base . 'RepositoryInterface';
            }
            return $m[0];
        }, $class);

        return $class;
    }

    protected function qualifyClass($name)
    {
        $name = preg_replace('/RepositoryInterface$/', '', $name);
        return parent::qualifyClass($name . 'RepositoryInterface');
    }

    protected function getOptions()
    {
        return [
            ['module', null, InputOption::VALUE_REQUIRED, 'Module name (e.g. Expenses)'],
            ['force',  null, InputOption::VALUE_NONE,     'Overwrite existing files'],
        ];
    }
}
