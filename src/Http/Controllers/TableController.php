<?php

namespace NoaPe\Beluga\Http\Controllers;

use NoaPe\Beluga\Actions\DeleteAction;
use NoaPe\Beluga\Actions\DownloadAction;
use NoaPe\Beluga\Actions\EditAction;
use NoaPe\Beluga\Actions\ShowAction;
use NoaPe\Beluga\Http\Components\Table;
use NoaPe\Beluga\ShellController;

class TableController extends ShellController
{
    protected $layout = 'beluga::layouts.default';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->render(Table::class, [
            'layout' => $this->layout,
            'actions' => [
                ShowAction::class,
                EditAction::class,
                DownloadAction::class,
                DeleteAction::class,
            ],
            'custom_columns' => [
                'Custom column' => function ($line) {
                    return $line->id;
                },
            ],
        ]);
    }
}
