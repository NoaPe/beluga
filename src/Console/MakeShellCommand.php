<?php

namespace NoaPe\Beluga\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use NoaPe\Beluga\Beluga;
use Illuminate\Support\Str;

class MakeShellCommand extends GeneratorCommand
{
    protected $signature = 'beluga:shell {name}';

    protected $description = 'Create a new shell file.';

    protected $type = 'Shell';

    protected function getStub()
    {
        return __DIR__.'/stubs/shell.php.stub';
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
        return $rootNamespace.'\Shells';
    }
}