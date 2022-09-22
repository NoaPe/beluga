<?php

namespace NoaPe\Beluga;

use NoaPe\Beluga\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use NoaPe\Beluga\Http\Components\Table;
use NoaPe\Beluga\Http\Components\Form;
use NoaPe\Beluga\Http\Components\Show;



abstract class ShellController extends Controller
{
    /**
     * The shell instance.
     *
     * @var \NoaPe\Beluga\Shell
     */
    protected $shell;

    /**
     * The shell class name.
     * 
     * @var string
     */
    protected $shellClass;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Replace in the base name the "Controller" string
        $shell = Str::replaceLast('Controller', '', class_basename($this));
        $this->shellClass = Beluga::qualifyShell($shell);
        $this->shell = new ($this->shellClass)();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response((new Table($this->shell))->render());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response((new Form($this->shell))->render());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Data validation
        $this->validate($request, $this->shell->getValidationRules());

        // Create the model
        $model = $this->shellClass;
        $model = new $model();
        $model->fill($request->all());

        // Save the model
        $model->save();

        // Json success response
        return response()->json([
            'success' => true,
            'message' => 'The ' . $this->shell->getName() . ' has been created.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response((new Show($this->shellClass::findOrFail($id)))->render());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Request database
        $model = $this->shellClass;
        $model = $model::findOrFail($id);

        return response((new Form($this->shellClass::findOrFail($id)))->render());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Data validation
        $this->validate($request, $this->shell->getValidationRules());

        // Request database
        $model = $this->shellClass;
        $model = $model::findOrFail($id);

        // Update the model
        $model->fill($request->all());

        // Save the model
        $model->save();

        // Json success response
        return response()->json([
            'success' => true,
            'message' => 'The ' . $this->shell->getName() . ' has been updated.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Request database
        $model = $this->shellClass;
        $model = $model::findOrFail($id);

        // Delete the model
        $model->delete();

        // Json success response
        return response()->json([
            'success' => true,
            'message' => 'The ' . $this->shell->getName() . ' has been deleted.',
        ]);
    }
}