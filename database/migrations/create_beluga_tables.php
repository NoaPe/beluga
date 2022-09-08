<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Http\Models\Table;

return new class extends Migration
{
    public function up()
    {
        Table::up();
    }

    public function down()
    {
        Table::down();
    }
};
