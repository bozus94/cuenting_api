<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class MakeApiRequestCommand extends GeneratorCommand
{
    protected $name = 'make:api-request';
    protected $description = 'Create a new apiFormRequest';
    protected $type = 'API Request';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        return base_path('stubs/cuenting/api.request.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {

        $apiVersion = $this->option('api-version');
        if ($apiVersion) {
            return  $rootNamespace . '\\Http\\Api\\v' . $apiVersion . '\\Controllers';
        }
        return $rootNamespace . '\\Http\\Api\\V1\\Requests';
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        // Permite inyectar reglas rápidas con --rules (opcional)
        $rules = (string) $this->option('rules');
        $class = str_replace('DummyRules', $rules !== '' ? $rules : "'// TODO: define reglas'", $class);

        return $class;
    }

    protected function qualifyClass($name)
    {
        // Normaliza a *Request
        $name = preg_replace('/Request$/', '', $name);
        return parent::qualifyClass($name . 'Request');
    }

    protected function getOptions()
    {
        return [
            ['rules',       null, InputOption::VALUE_OPTIONAL, 'Inline rules array content'],
            ['api-version', null, InputOption::VALUE_OPTIONAL, 'Define a version of api'],
            ['force',       null, InputOption::VALUE_NONE,     'Overwrite existing files'],
        ];
    }
}
