<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusAddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_adds', function (Blueprint $table) {            
            $table->bigInteger('bonus_id')->unsigned();
            $table->primary('bonus_id');
            $table->bigInteger('bonus_type_id')->unsigned();
            $table->char('comment',250)->nullable();
            $table->date('die')->nullable();
            $table->Integer('spend')->default(0);
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
        Schema::dropIfExists('bonus_adds');
    }
}
