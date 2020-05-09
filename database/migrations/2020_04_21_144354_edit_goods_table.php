<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('comment');

            $table->bigInteger('user_id')->unsigned();
        });     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {                
        Schema::table('goods', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable();
            $table->char('comment',250)->nullable();

            $table->dropColumn('user_id');
        }); 

    }
}
