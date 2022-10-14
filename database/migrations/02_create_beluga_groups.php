<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Http\Models\Group;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Group::up();
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down()
    {
        Group::down();
    }
};
