<?php

namespace NoaPe\Beluga\Http\Controllers;

class SchemaController extends Controller
{
    public function index()
    {
        return view('beluga::index', compact('schemas'));
    }

    public function show($name)
    {
        return view('beluga::show', compact('schema'));
    }

    public function edit($name)
    {
        return view('beluga::edit', compact('schema'));
    }

    public function create($name)
    {

    }

    public function export($name)
    {

    }

}