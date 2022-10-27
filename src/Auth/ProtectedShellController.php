<?php

namespace NoaPe\Beluga\Auth;

use Illuminate\Http\Request;
use NoaPe\Beluga\ShellController;

class ProtectedShellController extends ShellController
{
    /**
     * Permission prefix
     *
     * @var string
     */
    protected $permission_prefix;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

        if (empty($this->permission_prefix)) {
            $this->permission_prefix = $this->shell->getElementName().'_';
        }
    }

    /**
     * Check if user has hasPermission method at each call
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists(auth()->user(), 'hasPermission')) {
            abort(403);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Get permission prefix
     *
     * @return string
     */
    public function getPermissionPrefix()
    {
        return $this->permission_prefix;
    }

    /**
     * Check if user has permission
     *
     * @param  string  $permission
     * @return bool
     *
     * @throws \Exception
     */
    protected function userHasPermission($permission)
    {
        $method_name = 'hasPermission';
        if (method_exists(auth()->user(), $method_name)) {
            return auth()->user()->$method_name($permission);
        } else {
            throw new \Exception('Method "'.$method_name.'" not found in "'.get_class(auth()->user()).'" class.');
        }
    }

    /**
     * User can read
     *
     * @return bool
     */
    public function userCanView()
    {
        return $this->userHasPermission($this->getPermissionPrefix().'view');
    }

    /**
     * User can create
     *
     * @return bool
     */
    public function userCanCreate()
    {
        return $this->userHasPermission($this->getPermissionPrefix().'create');
    }

    /**
     * User can update
     *
     * @return bool
     */
    public function userCanUpdate()
    {
        return $this->userHasPermission($this->getPermissionPrefix().'update');
    }

    /**
     * User can delete
     *
     * @return bool
     */
    public function userCanDelete()
    {
        return $this->userHasPermission($this->getPermissionPrefix().'delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (! $this->userCanView()) {
            abort(403);
        }

        return parent::index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (! $this->userCanCreate()) {
            abort(403);
        }

        return parent::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (! $this->userCanCreate()) {
            abort(403);
        }

        return parent::store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (! $this->userCanView()) {
            abort(403);
        }

        return parent::show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (! $this->userCanUpdate()) {
            abort(403);
        }

        return parent::edit($id);
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
        if (! $this->userCanUpdate()) {
            abort(403);
        }

        return parent::update($request, $id);
    }

    /**
     * Remove the specified resource from storage. And return to the index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (! $this->userCanDelete()) {
            abort(403);
        }

        return parent::destroy($id);
    }
}
