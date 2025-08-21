<?php

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceCommand extends GeneratorCommand
{
    protected $name = 'make:service';
    protected $description = 'Create a new Service class for Cuenting (optionally with interface)';
    protected $type = 'Service';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        $base = base_path('stubs/cuenting');
        return $this->option('with-interface')
            ? $base . '/service.with-interface.stub'
            : $base . '/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $module = $this->option('module') ?: $this->getNameInput();
        return $rootNamespace . '\\Services\\' . $module;
    }

    public function handle()
    {
        // Primero, generar interfaz si se pide
        if ($this->option('with-interface')) {
            $this->call('make:interface', [
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
        $contracts  = "App\\Services\\{$module}\\Contracts";
        $ifaceName  = "{$baseName}ServiceInterface";

        $class = str_replace(
            ['DummyContractsNamespace', 'DummyInterface'],
            [$contracts, $ifaceName],
            $class
        );

        // Asegurar sufijo Service
        $class = preg_replace_callback('/class\s+([A-Za-z0-9_]+)/', function ($m) {
            $base = $m[1];
            if (!str_ends_with($base, 'Service')) {
                return 'class ' . $base . 'Service';
            }
            return $m[0];
        }, $class);

        return $class;
    }

    protected function baseName(): string
    {
        $name = $this->getNameInput();
        $name = preg_replace('/Service$/', '', $name);
        return $name;
    }

    protected function qualifyClass($name)
    {
        $name = preg_replace('/Service$/', '', $name);
        return parent::qualifyClass($name . 'Service');
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
