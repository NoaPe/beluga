<?php

namespace NoaPe\Beluga\Http\Controllers\Concerns;

trait HasSubGroups
{
    /**
     * Constructor
     *
     * @return void
     */
    public function setRelations()
    {
        $this->setRelationActions('show,edit,delete,download');

        $this->setRelationCustomColumns([
            'Group count' => function ($line) {
                //return $line->groups()->count();
                return 'TODO';
            },
            'Data count' => function ($line) {
                //return $line->datas()->count();
                return 'TODO';
            },
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->views['index'], [
            'shell' => $this->shell,
            'actions' => 'show,edit,delete,download',
            'custom_columns' => [
                'Group count' => function ($line) {
                    return $line->groups()->count();
                },
                'Datas count' => function ($line) {
                    return $line->datas()->count();
                },
            ],
        ]);
    }
}
