<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Http\Models\Data;

return new class extends Migration
{
    public function up()
    {
        Data::up();
    }

    public function down()
    {
        Data::down();
    }
};
