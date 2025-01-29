<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeModel extends GeneratorCommand
{
    protected $signature = 'make:model {name}';
    protected $description = 'Create a new Eloquent model class';
    protected $type = 'Model';

    protected function getStub()
    {
        return base_path('vendor/laravel/framework/src/Illuminate/Database/Console/Factories/stubs/model.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Models';
    }
}
