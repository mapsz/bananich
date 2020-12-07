<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedOrderSharedOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_order_shared_order_status', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('shared_order_id')->unsigned();
            $table->bigInteger('shared_order_status_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('shared_orders', function (Blueprint $table) {
            $table->integer('status_id')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_order_shared_order_status');
        Schema::table('shared_orders', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
}
