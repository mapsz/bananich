<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemItemStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_item_status', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('item_status_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_item_status');
    }
}
