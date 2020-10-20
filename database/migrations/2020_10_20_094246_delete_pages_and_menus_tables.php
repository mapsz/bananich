<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletePagesAndMenusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Pages
        Schema::dropIfExists('pages');

        //Menu
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_menu_type');
        Schema::dropIfExists('menu_types');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Pages
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('menu_id')->unsigned();
            $table->text('text');
            $table->char('link',255);
        });

        //Menus
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name',250);
            $table->integer('sort')->default(0);
        });

        //Menu types
        Schema::create('menu_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name',250);
        });

        //Menus <-> Menu types
        Schema::create('menu_menu_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('menu_id')->unsigned();
            $table->bigInteger('menu_type_id')->unsigned();
        });        
        Artisan::call('db:seed', array('--class' => 'MenuTableSeeder'));
        
    }
}
