<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('cart_presents', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign('cart_items_cart_id_foreign');
            $table->dropIndex('cart_items_cart_id_foreign');
        });
        Schema::table('cart_presents', function (Blueprint $table) {
            $table->dropForeign('cart_items_cart_id_foreign');
            $table->dropIndex('cart_items_cart_id_foreign');
        });
    }
}
