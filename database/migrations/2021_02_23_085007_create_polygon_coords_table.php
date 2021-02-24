<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolygonCoordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polygon_coords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('polygon_id')->unsigned();
            $table->double('x', 200, 8)->unsigned();
            $table->double('y', 200, 8)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polygon_coords');
    }
}
