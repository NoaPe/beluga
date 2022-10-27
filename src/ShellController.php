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
     * Relation actions
     *
     * @var array
     */
    protected $relation_actions = [];

    /**
     * Relation custom columns
     *
     * @var array
     */
    protected $relation_custom_columns = [];

    /**
     * Views
     * 
     * @var array
     */
    protected $views = [
        'index' => 'beluga::index',
        'create' => 'beluga::create',
        'edit' => 'beluga::edit',
        'show' => 'beluga::show',
    ];

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
     * Set relation actions
     *
     * @param  array  $actions
     * @return void
     */
    public function setRelationActions(array $actions)
    {
        $this->relation_actions = $actions;
    }

    /**
     * Set relation custom columns
     *
     * @param  array  $columns
     * @return void
     */
    public function setRelationCustomColumns(array $columns)
    {
        $this->relation_custom_columns = $columns;
    }

    /**
     * __call magic function for call showRelation method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return  mixed
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'showRelation')) {
            $relation = Str::replaceFirst('showRelation', '', $method);

            return $this->showRelation($relation, ...$parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Get redirection route
     * 
     * @param  string  $action
     * @param  array  $parameters
     * @return string
     */
    protected function getRedirectionRoute($action, $parameters = null)
    {
        $route = $this->shell->getRoute().'.'.$action;

        if (empty($parameters)) {
            return route($route);
        }

        return route($route, $parameters);
    }

    /**
     * Show table from a relation.
     *
     * @param  string  $relation
     * @param  mixed  $id
     * @return \Illuminate\View\View
     */
    public function showRelation($relation, $id)
    {
        $this->shellClass::findOrFail($id);
        $settings = $this->shell->getDataSchema(Str::snake($relation))->settings;

        $foreign_key = isset($settings->foreign_key) ? $settings->foreign_key : $this->shell->getForeignKey();

        $lines = $settings->class::where($foreign_key, $id);
        if (isset($settings->where)) {
            $lines = $lines->where(...$settings->where);
        }

        return view($this->views['index'], [
            'shell' => $this->shell,
            'lines' => $lines->get(),
            'actions' => $this->relation_actions,
            'custom_columns' => $this->relation_custom_columns,
        ]);
    }

    /**
     * Display a listing of the resource. Return view.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->views['index'], [
            'shell' => $this->shell
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->views['create']);
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
        return redirect($this->getRedirectionRoute('index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view($this->views['show'], [
            'shell' => $this->shellClass::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return view($this->views['edit'], [
            'shell' => $this->shellClass::findOrFail($id)
        ]);
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
        return redirect($this->getRedirectionRoute('index'));
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
        return redirect($this->getRedirectionRoute('index'));
    }
}
