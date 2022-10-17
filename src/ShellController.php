<?php

namespace NoaPe\Beluga;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NoaPe\Beluga\Http\Components\Form;
use NoaPe\Beluga\Http\Components\Show;
use NoaPe\Beluga\Http\Components\Table;
use NoaPe\Beluga\Http\Controllers\Controller;
use NoaPe\Beluga\Auth\HasShellWithPermissions;

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
        return $this->render(Table::class, ['layout' => $this->layout]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->render(Form::class, ['layout' => $this->layout]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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

        // Redirect to the index
        return redirect()->route($this->shell->getRoute().'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->render(Show::class,
            ['layout' => $this->layout],
            $this->shellClass::findOrFail($id)
        );
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
            [
                'layout' => $this->layout,
                'method' => 'PUT',
            ],
            $this->shellClass::findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage and come back to the latest page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Request database
        $model = $this->shellClass;
        $model = $model::findOrFail($id);

        // Data validation
        //dd($model->getValidationRules());
        $this->validate($request, $model->getValidationRules());

        // Update the model
        $model->update($request->all());

        // Save the model
        $model->save();

        // Redirect to the index
        return redirect()->route($this->shell->getRoute().'.index');
    }

    /**
     * Remove the specified resource from storage. And return to the index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Request database
        $model = $this->shellClass;
        $model = $model::findOrFail($id);

        // Delete the model
        $model->delete();

        // Redirect to the index
        return redirect()->route($this->shell->getRoute().'.index');
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
