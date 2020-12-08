<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedOrderContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_order_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shared_order_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->char('name',50);
            $table->char('phone',30);
            $table->char('email',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_order_contacts');
    }
}
