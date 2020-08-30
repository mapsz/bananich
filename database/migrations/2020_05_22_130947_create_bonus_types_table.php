<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name',250);
            $table->tinyInteger('die')->nullable();
        });
        DB::table('bonus_types')->insert([
            'id' => '1',
            'name' => 'Админ',
        ]);
        DB::table('bonus_types')->insert([
            'id' => '2',
            'name' => 'Покупка',
            'die' => 14,
        ]);
        DB::table('bonus_types')->insert([
            'id' => '3',
            'name' => 'Сгорание',
        ]);
        DB::table('bonus_types')->insert([
            'id' => '4',
            'name' => 'Резервация',
        ]);    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonus_types');
    }
}
