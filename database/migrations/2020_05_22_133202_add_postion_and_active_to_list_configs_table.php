<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostionAndActiveToListConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_configs', function (Blueprint $table) {
            $table->smallInteger('position')->unsigned()->nullable();
            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_configs', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('active');
        });
    }
}
