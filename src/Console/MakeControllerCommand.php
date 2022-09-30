<?php

namespace NoaPe\Beluga\Console;

use Illuminate\Console\GeneratorCommand;

class MakeControllerCommand extends GeneratorCommand
{
    protected $signature = 'beluga:controller {name}';

    protected $description = 'Create a new shell controller file.';

    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__.'/stubs/controller.php.stub';
    }

    public function handle()
    {
        parent::handle();

        $this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        $class = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($class);

        $content = file_get_contents($path);

        $content = $this->populateStub($content, $this->getNameInput());

        file_put_contents($path, $content);
    }

    /**
     * Populate the place-holders in the migration stub.
     *
     * @param  string  $stub
     * @param  string  $shell
     * @return string
     */
    protected function populateStub($stub, $shell)
    {
        $stub = str_replace(
            '{{ shell }}',
            $shell, $stub
        );

        return $stub;
    }

    /**
     * Get default namespace.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }
}
