<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Shells\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::up();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::down();
    }
};
