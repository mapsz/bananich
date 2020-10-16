<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 100);
            $table->char('from', 100)->nullable();
            $table->text('description')->nullable();
            $table->char('unit',50)->nullable();
            $table->float('unit_sys')->default(1)->nullable();
            $table->integer('sort')->default(0);
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('gruzka_priority')->default(0);
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
        Schema::dropIfExists('products');
    }
}
