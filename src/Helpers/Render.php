<?php

namespace NoaPe\Beluga\Helpers;

class Render
{
    /**
     * Static function for calculate the number of column for a label.
     *
     * @param  \stdClass  $data
     */
    public static function labelColumn($data)
    {
        $column = 12;

        $row = isset($data->settings->row) ? $data->settings->row : 2;

        if ($row == 2) {
            $column = 6;
        } elseif ($row == 1) {
            $column = 6;
        }

        return $column;
    }

    /**
     * Static function for calculate the number of column for a input.
     *
     * @param  \stdClass  $data
     */
    public static function inputColumn($data)
    {
        $column = 12;

        $row = isset($data->settings->row) ? $data->settings->row : 2;

        if ($row == 2) {
            $column = 12;
        } elseif ($row == 1) {
            $column = 6;
        }

        return $column;
    }
}
