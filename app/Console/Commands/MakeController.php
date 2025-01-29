<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeController extends GeneratorCommand
{
    protected $signature = 'make:controller {name}';
    protected $description = 'Create a new controller class';
    protected $type = 'Controller';

    protected function getStub()
    {
        return base_path('vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/controller.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Http\\Controllers';
    }
}
