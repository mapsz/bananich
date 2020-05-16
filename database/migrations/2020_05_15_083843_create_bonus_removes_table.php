<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusRemovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_removes', function (Blueprint $table) {
            $table->bigInteger('bonus_id')->unsigned();
            $table->primary('bonus_id');
            $table->bigInteger('bonus_type_id')->unsigned();
            $table->char('comment',250)->nullable();
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
        Schema::dropIfExists('bonus_removes');
    }
}
