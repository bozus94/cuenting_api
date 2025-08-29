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
        return $this->option('i')
            ? $base . '/repository.with-interface.stub'
            : $base . '/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($module = $this->option('module')) {
            return $rootNamespace . '\\Repositories\\' . $module;
        }
        return $rootNamespace . '\\Repositories';
    }

    public function handle()
    {
        if ($this->option('i')) {
            $props = $this->option('module') ? [
                'name'     => $this->getNameInput(),
                '--module' => $this->option('module'),
                '--force'  => $this->option('force'),
            ] : [
                'name'     => $this->getNameInput(),
                '--force'  => $this->option('force'),
            ];

            $this->call('make:repository-interface', $props);
        }

        return parent::handle();
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $module     = $this->option('module');
        $baseName   = $this->baseName();
        $contracts  = $module
            ? "App\\Repositories\\{$module}\\Contracts"
            : "App\\Repositories\\Contracts";

        $ifaceName  = "{$baseName}RepositoryInterface";
        $class = str_replace(
            ['DummyContractsNamespace', 'DummyInterface'],
            [$contracts, $ifaceName],
            $class
        );
        // Asegurar sufijo Repository
        /*         $class = preg_replace_callback('/class\s+([A-Za-z0-9_\s]+)/', function ($m) {
            $base = $m[1];
            if (!str_ends_with($base, 'Repository')) {
                return 'class ' . $base . 'Repository';
            }
            return $m[0];
        }, $class); */

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
            ['i',              null, InputOption::VALUE_NONE,     'Generate and implement interface'],
            ['force',          null, InputOption::VALUE_NONE,     'Overwrite existing files'],
        ];
    }
}
