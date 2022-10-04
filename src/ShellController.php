<?php

namespace NoaPe\Beluga;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NoaPe\Beluga\Http\Components\Form;
use NoaPe\Beluga\Http\Components\Show;
use NoaPe\Beluga\Http\Components\Table;
use NoaPe\Beluga\Http\Controllers\Controller;

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
     * The layout to use.
     * 
     * @var string
     */
    protected $layout = '';

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
        return $this->render(Table::class, [ 'layout' => $this->layout ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->render(Form::class, [ 'layout' => $this->layout ]);
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
            'message' => 'The '.$this->shell->getName().' has been created.',
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

        return $this->render(
            Form::class,
            [ 'layout' => $this->layout ],
            $this->shellClass::findOrFail($id)
        );
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
            'message' => 'The '.$this->shell->getName().' has been updated.',
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
            'message' => 'The '.$this->shell->getName().' has been deleted.',
        ]);
    }

    /**
     * Render component with datas.
     * 
     * @param  string  $component
     * @param  array  $datas
     * @param  Shell  $shell
     * @return \Illuminate\Http\Response
     */
    public function render($component, $datas = [], $shell = null)
    {
        $shell = $shell ?? $this->shell;

        $component = new $component($shell);

        $component->addDatas($datas);

        return response($component->render());
    }
}
