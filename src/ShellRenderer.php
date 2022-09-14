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
        $schema = $shell::getSchema();

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
     * @param  array  $settings
     * @return \Illuminate\View\View
     */
    public static function table($shell, $render_settings = [], $internal = false)
    {
        /**
         * Get the schema from the shell.
         */
        $schema = $shell::getSchema();

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
     * @param  array  $group
     * @param  string  $prefix
     * @return \Illuminate\View\View
     */
    public static function group($group, $prefix = '', $internal = false)
    {
        /**
         * Return the group view with the group and the prefix.
         */
        return view('beluga::components.group', [
            'group' => $group,
            'prefix' => $prefix,
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
        $schema = $shell->schema;

        if ($prefix) {
            $parent = $schema;

            /**
             * We explode the prefix with "-" and we take successive sub groups of the schema.
             */
            $groupsName = explode('-', $prefix);
            
            foreach ($groupsName as $groupName) {
                $parent = $parent->groups->$groupName;
            }

            $data = $parent->datas->$name;
        } else {
            $data = $schema->datas->$name;
        }

        // Return the view from the data type
        return $data->renderInput();
    }
}
