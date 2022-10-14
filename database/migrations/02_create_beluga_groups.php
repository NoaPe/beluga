<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Http\Models\Group;

return new class extends Migration
{
    public function up()
    {
        Group::up();
    }

    public function down()
    {
        Group::down();
    }
};
