<?php

namespace NoaPe\Beluga;

class ShellRenderer
{
    /**
     * Function for render a form for a shell.
     *
     * @param $shell
     * @return \Illuminate\View\View
     */
    public static function form($shell, $internal = false)
    {
        /**
         * Get the schema from the shell.
         */
        $schema = $shell->getSchema();

        /**
         * Return the form view with the schema.
         */
        return view('beluga::components.form', [
            'schema' => $schema,
            'internal' => $internal,
        ]);
    }

    /**
     * Function for render a table of all lines in the database for a shell with render settings.
     *
     * @param    $shell
     * @param  array  $render_settings
     * @return \Illuminate\View\View
     */
    public static function table($shell, $render_settings = [], $internal = false)
    {
        /**
         * Get the schema from the shell.
         */
        $schema = $shell->getSchema();

        /**
         * Get all lines from the shell.
         */
        $lines = $shell::all();

        /**
         * Return the table view with the schema and the lines.
         */
        return view('beluga::components.table', [
            'schema' => $schema,
            'lines' => $lines,
            'render_settings' => $render_settings,
            'internal' => $internal,
        ]);
    }

    /**
     * Function for render a group.
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @param  string  $name
     * @param  string  $prefix
     * @param  bool  $internal
     * @return \Illuminate\View\View
     */
    public static function group($shell, $name, $prefix = '', $internal = false)
    {
        $schema = $shell->getSchema();

        /**
         * Return the group view with the group and the prefix.
         */
        return view('beluga::components.group')->with([
            'group' => $shell->getGroup($name),
            'name' => $name,
            'prefix' => $name.'-'.$prefix,
            'internal' => $internal,
        ]);
    }

    /**
     * Function for render an input for a data of a shell.
     *
     * @param    $shell
     * @param  string  $prefix
     * @param  string  $name
     * @return \Illuminate\View\View
     */
    public static function input($shell, $prefix, $name, $internal = false)
    {
        $schema = $shell->getSchema();

        if ($prefix) {
            $parent = $schema;

            /**
             * We explode the prefix with "-" and we take successive sub groups of the schema.
             */
            $groupsName = explode('-', $prefix);

            foreach ($groupsName as $groupName) {
                if ($groupName !== '') {
                    $parent = $parent->groups->$groupName;
                }
            }

            $data = $parent->datas->$name;
        } else {
            $data = $schema->datas->$name;
        }

        // Return the view from the data type
        return $data->getType($shell)->renderInput();
    }
}
