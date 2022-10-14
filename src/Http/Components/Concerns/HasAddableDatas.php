<?php

namespace NoaPe\Beluga\Http\Components\Concerns;

trait HasAddableDatas
{
    /**
     * Datas
     *
     * @var array
     */
    protected $datas = [];

    /**
     * Add data.
     *
     * @param  array  $datas
     * @return void
     */
    public function addDatas($datas)
    {
        $this->datas = array_merge($this->datas, $datas);
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getDatas()
    {
        return array_merge($this->datas, $this->baseDatas());
    }
}
