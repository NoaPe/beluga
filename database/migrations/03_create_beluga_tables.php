<?php

use Illuminate\Database\Migrations\Migration;
use NoaPe\Beluga\Http\Models\Table;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Table::up();
    }
    
    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down()
    {
        Table::down();
    }
};
