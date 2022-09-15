<?php

namespace NoaPe\Beluga\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NoaPe\Beluga\Http\Models\Table;

class SchemaController extends Controller
{
    public function index()
    {
        return view('beluga::index');
    }

    public function show($name)
    {
        $schema = $this->getShellClass($name)::getSchema();

        return view('beluga::show', compact('schema'));
    }

    /**
     * Get schema information from a shell name and send it to the edition view.
     */
    public function edit($name)
    {
        $schema = $this->getShellClass($name)::getSchema();

        return view('beluga::edit', compact('schema'));
    }

    /**
     * Return Shell class from name. If the name contains the prefix, take the internal namespace and remove the prefix, otherwise the external.
     *
     * @param  string  $name
     * @return string
     */
    public function getShellClass($name)
    {
        $shell_namespace = config('beluga.shell_namespace');
        $prefix = config('beluga.table_prefix');

        if (Str::startsWith($name, $prefix)) {
            $shell_namespace = config('beluga.internal_shell_namespace');
            $name = Str::replaceFirst($prefix, '', $name);
        }

        return $shell_namespace.'\\'.$name;
    }

    /**
     * Save or store a new line in the shell table.
     *
     * @param  string  $shell
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($shell, Request $request)
    {
        $request->validate($shell::getValidationRules());

        /**
         * If the id is not set, create a new line else update the line.
         */
        if (is_null($request->id)) {
            $shell::create($request->all());
        } else {
            $shell::find($request->id)->update($request->all());
        }

        return redirect('/beluga')->with('success', 'Schema saved!');
    }

    /**
     * Export the schema to a json response.
     *
     * @param  string  $shell
     * @return \Illuminate\Http\JsonResponse
     */
    public function export($shell)
    {
        $shell = $this->getShellClass($shell);

        return response()->json($shell::getSchema(), 200, [], JSON_PRETTY_PRINT);
    }
}
