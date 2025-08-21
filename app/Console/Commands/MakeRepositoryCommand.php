<?php

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeRepositoryCommand extends GeneratorCommand
{
    protected $name = 'make:repository';
    protected $description = 'Create a new Repository class for Cuenting (optionally with interface)';
    protected $type = 'Repository';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        $base = base_path('stubs/cuenting');
        return $this->option('with-interface')
            ? $base . '/repository.with-interface.stub'
            : $base . '/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $module = $this->option('module') ?: $this->getNameInput();
        return $rootNamespace . '\\Repositories\\' . $module;
    }

    public function handle()
    {
        if ($this->option('with-interface')) {
            $this->call('make:repository-interface', [
                'name'     => $this->getNameInput(),
                '--module' => $this->option('module'),
                '--force'  => $this->option('force'),
            ]);
        }

        return parent::handle();
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $module     = $this->option('module') ?: $this->getNameInput();
        $baseName   = $this->baseName();
        $contracts  = "App\\Repositories\\{$module}\\Contracts";
        $ifaceName  = "{$baseName}RepositoryInterface";

        $class = str_replace(
            ['DummyContractsNamespace', 'DummyInterface'],
            [$contracts, $ifaceName],
            $class
        );

        // Asegurar sufijo Repository
        $class = preg_replace_callback('/class\s+([A-Za-z0-9_]+)/', function ($m) {
            $base = $m[1];
            if (!str_ends_with($base, 'Repository')) {
                return 'class ' . $base . 'Repository';
            }
            return $m[0];
        }, $class);

        return $class;
    }

    protected function baseName(): string
    {
        $name = $this->getNameInput();
        $name = preg_replace('/Repository$/', '', $name);
        return $name;
    }

    protected function qualifyClass($name)
    {
        $name = preg_replace('/Repository$/', '', $name);
        return parent::qualifyClass($name . 'Repository');
    }

    protected function getOptions()
    {
        return [
            ['module',         null, InputOption::VALUE_REQUIRED, 'Module name (e.g. Expenses)'],
            ['with-interface', null, InputOption::VALUE_NONE,     'Generate and implement interface'],
            ['force',          null, InputOption::VALUE_NONE,     'Overwrite existing files'],
        ];
    }
}
