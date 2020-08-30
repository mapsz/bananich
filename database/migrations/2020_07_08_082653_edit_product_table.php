<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('description');
            $table->dropColumn('gruzka_priority');
            $table->dropColumn('strews');
            $table->dropColumn('unit');
            $table->dropColumn('unit_sys');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->float('unit')->default(1)->nullable();
            $table->tinyInteger('status')->default(0);
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('unit');
            $table->dropColumn('status');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->char('from', 100)->nullable();
            $table->text('description')->nullable();            
            $table->integer('gruzka_priority')->default(0);
            $table->Integer('strews')->unsigned()->nullable();
            $table->char('unit',50)->nullable();
            $table->float('unit_sys')->default(1)->nullable();
        });
    }
}
