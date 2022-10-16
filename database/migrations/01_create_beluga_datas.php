<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Http\Models\Data;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Data::up();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Data::down();
    }
};
