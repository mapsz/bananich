<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolygonPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polygon_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('polygon_id')->unsigned();
            $table->double('price', 10, 2)->unsigned();
            $table->tinyInteger('day')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->char('time',6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polygon_prices');
    }
}
