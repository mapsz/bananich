<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchiveProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->char('name', 100);
            $table->char('from', 100)->nullable();
            $table->text('description')->nullable();
            $table->char('unit',50)->nullable();
            $table->float('unit_sys')->default(1)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamp('archive_at');
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
        Schema::dropIfExists('archive_products');
    }
}
