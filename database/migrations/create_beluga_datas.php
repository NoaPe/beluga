<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
