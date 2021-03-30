<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 50);
            $table->tinyInteger('type');
            $table->integer('term');
            $table->integer('value');
        });

        {//Seed
            DB::table('memberships')->insert([
                'id' => 10,
                'name' => 'Абонемент',
                'type' => 10,
                'term' => 14,
                'value' => 100,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships');
    }
}
