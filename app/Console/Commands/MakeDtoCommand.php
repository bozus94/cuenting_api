<?php

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeDtoCommand extends GeneratorCommand
{
    protected $name = 'make:dto';
    protected $description = 'Create a new DTO class for Cuenting (data|request|response)';
    protected $type = 'DTO';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        $base = base_path('stubs/cuenting');
        $type = $this->option('type');

        return match ($type) {
            'request'  => $base . '/dto.request.stub',
            'response' => $base . '/dto.response.stub',
            default    => $base . '/dto.data.stub',
        };
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $module = $this->option('module');
        $type   = $this->option('type');

        if ($module) {
            return match ($type) {
                'request'  => $rootNamespace . '\\DTOs\\' . $module . '\\Requests',
                'response' => $rootNamespace . '\\DTOs\\' . $module . '\\Responses',
                default    => $rootNamespace . '\\DTOs\\' . $module,
            };
        }

        return match ($type) {
            'request'  => $rootNamespace . '\\DTOs\\Requests',
            'response' => $rootNamespace . '\\DTOs\\Responses',
            default    => $rootNamespace . '\\DTOs',
        };
    }

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        // Props parsing: "amount:float,occurredAt:\DateTimeImmutable,note:?string"
        $props = trim((string) $this->option('props'));
        [$phpDoc, $propsBlock, $ctorParams] = $this->generateProps($props);

        $class = str_replace(
            ['DummyPhpDoc', 'DummyProps', 'DummyCtor'],
            [$phpDoc, $propsBlock, $ctorParams],
            $class
        );

        // Sufijo de clase según tipo
        $type = $this->option('type');
        $suffix = match ($type) {
            'request'  => 'RequestDTO',
            'response' => 'ResponseDTO',
            default    => 'DTO',
        };

        // Asegurar sufijo en el nombre final si el dev no lo puso
        $class = preg_replace_callback('/class\s+([A-Za-z0-9_]+)/', function ($m) use ($suffix) {
            $base = $m[1];
            if (!str_ends_with($base, $suffix)) {
                return 'class ' . $base . $suffix;
            }
            return $m[0];
        }, $class);

        return $class;
    }

    protected function generateProps(string $props): array
    {
        if ($props === '') {
            return [
                "/**\n *DTO sin propiedades declaradas.\n */ ",
                "// TODO: agrega propiedades\n",
                "// TODO: agrega parámetros de constructor si es necesario\n "
            ];
        }

        $items = array_filter(array_map('trim', explode(',', $props)));
        $phpDoc = "/**\n";
        $propsBlock = '';
        $ctorParams = '';

        foreach ($items as $i => $item) {
            [$name, $type] = array_map('trim', explode(':', $item) + [1 => 'mixed']);
            $phpDoc .= " * @property {$type} \${$name}\n";
            $propsBlock .= " public {$type} \${$name};\n";
            $ctorParams .= ($i === 0 ? '' : ",\n") . " public {$type} \${$name}";
        }
        $phpDoc .= " */";

        return [$phpDoc, $propsBlock . "\n", $ctorParams === '' ? " // sin propiedades" : $ctorParams];
    }

    protected function getOptions()
    {
        return [
            ['module',  null, InputOption::VALUE_REQUIRED, 'Module name (e.g. Expenses)'],
            ['type',    null, InputOption::VALUE_REQUIRED, 'DTO kind: data|request|response', 'data'],
            ['props',   null, InputOption::VALUE_OPTIONAL, 'Command list of props "name:type,other:?string"', ''],
            ['force',   null, InputOption::VALUE_NONE,     'Overwrite existing files'],
        ];
    }

    protected function qualifyClass($name)
    {
        // Permite pasar solo "Expense" y que se coloque el sufijo según type
        $type = $this->option('type');
        $suffix = match ($type) {
            'request'  => 'RequestDTO',
            'response' => 'ResponseDTO',
            default    => 'DTO',
        };

        $name = preg_replace('/DTO$/', '', $name);
        $name = preg_replace('/RequestDTO$/', '', $name);
        $name = preg_replace('/ResponseDTO$/', '', $name);

        return parent::qualifyClass($name . $suffix);
    }
}
