<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name',75);
        });
        
        DB::table('pay_methods')->insert([
            'id' => '1',
            'name' => 'Наличные',
        ]);        
        DB::table('pay_methods')->insert([
            'id' => '2',
            'name' => 'Безналичные',
        ]);   
        DB::table('pay_methods')->insert([
            'id' => '3',
            'name' => 'Перевод Сбербанк',
        ]);   
        DB::table('pay_methods')->insert([
            'id' => '4',
            'name' => 'Перевод Тинькоф',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_methods');
    }
}
