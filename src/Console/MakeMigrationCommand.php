<?php

namespace NoaPe\Beluga\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use NoaPe\Beluga\Beluga;

class MakeMigrationCommand extends GeneratorCommand
{
    protected $signature = 'beluga:migration {name}';

    protected $description = 'Create a new migration file for a shell';

    protected $type = 'Migration';

    protected function getStub()
    {
        return __DIR__.'/stubs/migration.php.stub';
    }

    public function handle()
    {
        parent::handle();

        $this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        // Get the fully qualified class name (FQN)
        $qualify_shell = Beluga::qualifyShell($this->getNameInput());

        $path = $this->getPath($this->getNameInput());

        $content = file_get_contents($path);

        $content = $this->populateStub($content, $this->getNameInput(), $qualify_shell);

        file_put_contents($path, $content);
    }

    /**
     * Populate the place-holders in the migration stub.
     *
     * @param  string  $stub
     * @param  string  $shell
     * @param  string  $qualify_shell
     * @return string
     */
    protected function populateStub($stub, $shell, $qualify_shell)
    {
        $stub = str_replace(
            '{{ shell }}',
            $shell, $stub
        );
        $stub = str_replace(
            '{{ qualify_shell }}',
            $qualify_shell, $stub
        );

        return $stub;
    }

    /**
     * Get the full path to the migration.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::snake(trim($this->getNameInput()));

        return $this->getMigrationPath().'/'.$this->getDatePrefix().'_'.$name.'.php';
    }

    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }
}
