<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('unit_full', 8, 4)->unsigned()->nullable();
            $table->decimal('unit_full_result', 8, 4)->unsigned()->nullable();
            $table->char('unit_type',50)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('unit_full');
            $table->dropColumn('unit_full_result');
            $table->dropColumn('unit_type');
        });
    }
}
