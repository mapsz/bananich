<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->char('name', 100);
            $table->integer('quantity')->unsigned();
            $table->float('quantity_result')->unsigned()->nullable();
            $table->char('gram',50)->default(1);
            $table->float('gram_sys')->default(1);
            $table->decimal('price', 8, 2)->nullable();
            $table->char('image',250)->nullable();
            $table->char('comment',250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
