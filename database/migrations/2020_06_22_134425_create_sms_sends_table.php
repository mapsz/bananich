<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_sends', function (Blueprint $table) {
            $table->bigInteger('sms_id')->unsigned()->primary();
            $table->integer('priority')->unsigned();
            $table->integer('mailing')->unsigned()->nullable();
            $table->timestamp('send')->nullable();
            $table->timestamp('delivered')->nullable();
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
        Schema::dropIfExists('sms_sends');
    }
}
