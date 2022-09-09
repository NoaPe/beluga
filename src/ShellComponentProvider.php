<?php

namespace NoaPe\Beluga;

use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;

class ShellComponentProvider
{
    /**
     * Register the loading directives.
     */
    public function registerDirectives()
    {
        /**
         * Directive for loading shell.
         */
        Blade::directive('load-shell', function ($shell_name) {
            ShellComponentProvider::register(config('beluga.shell_namespace').'\\'.$shell_name);

            return '';
        });

        /**
         * Directive for loading internal shell.
         */
        Blade::directive('load-internal-shell', function ($shell_name) {
            ShellComponentProvider::register(config('beluga.internal_shell_namespace').'\\'.$shell_name);

            return '';
        });
    }

    /**
     * Register all the components for a shell.
     *
     * @param  string  $shell_name
     * @return void
     */
    public static function register($shell_name)
    {
        /**
         * Get the class from $shell name.
         */
        $shell = new $shell_name;

        /**
         * Register the form component.
         */
        Blade::component(self::form($shell), 'beluga-form::'.class_basename($shell));

        /**
         * Register the table component.
         */
        Blade::component(self::table($shell), 'beluga-table::'.class_basename($shell));

        /**
         * Register the inputs component for datas property and registerInputs function.
         */
        self::registerInputs($shell, $shell->datas);
    }

    /**
     * Register inputs component from datas array and a prefix.
     *
     * @param    $shell
     * @param  array  $datas
     * @param  string  $prefix
     * @return void
     */
    public static function registerInputs($shell, $datas, $prefix = '')
    {
        /**
         * Register inputs component from datas property.
         */
        foreach ($group->datas as $key => $data) {
            Blade::component(self::input($shell, $prefix, $key), 'beluga-input::'.$prefix.$key);
        }
    }

    /**
     * Register recursivly all the components for a group
     */
    public static function registerGroup($shell, $group, $prefix = '')
    {
        /**
         * Register inputs component from datas property.
         */
        self::registerInputs($shell, $group->datas, $prefix);

        /**
         * Register inputs component from groups property.
         */
        foreach ($group->groups as $key => $group) {
            self::registerGroup($shell, $group, $prefix.$key.'-');
        }
    }

    /**
     * Static function who return a component class for generate form for a shell.
     */
    public static function form($shell)
    {
        return new class($shell) extends Component
        {
            public $shell;

            public function __construct($shell)
            {
                $this->shell = $shell;
            }

            public function render()
            {
                /**
                 * User the ShellRenderer to render the form.
                 */

                return ShellRenderer::form($this->shell);
            }
        };
    }

    /**
     * Static function who return a component class for generate table for a shell.
     */
    public static function table($shell, $render_settings = [])
    {
        return new class($shell, $render_settings) extends Component
        {
            public $shell;

            public $render_settings;

            public function __construct($shell, $render_settings)
            {
                $this->shell = $shell;
                $this->render_settings = $render_settings;
            }

            public function render()
            {
                /**
                 * Use the ShellRenderer to render the table.
                 */
                return ShellRenderer::table($this->shell, $this->render_settings);
            }
        };
    }

    /**
     * Static function who return a component class for generate input for a shell.
     */
    public static function input($shell, $prefix, $key)
    {
        return new class($shell, $prefix, $key) extends Component
        {
            public $shell;

            public $prefix;

            public $key;

            public function __construct($shell, $prefix, $key)
            {
                $this->shell = $shell;
                $this->prefix = $prefix;
                $this->key = $key;
            }

            public function render()
            {
                /**
                 * Use the ShellRenderer to render the input.
                 */
                return ShellRenderer::input($this->shell, $this->prefix, $this->key);
            }
        };
    }
}
