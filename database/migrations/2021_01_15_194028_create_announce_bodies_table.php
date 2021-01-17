<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnounceBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce_bodies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name',50)->unique();
            $table->text('body');
            $table->timestamps();
        });

        
        {//Seed
            DB::table('announce_bodies')->insert([
                'id' => '1',
                'name' => 'kicked',
                'body' => 'Вы были удалены из <a href="/shared/order/<:order_link:>">закупки</a> организатором',
            ]);
            DB::table('announce_bodies')->insert([
                'id' => '2',
                'name' => 'overweight',
                'body' => 'Вы превысили допустимый лимит веса заказа на 4 кг. Каждые дополнительные 5 кг оплачиваются отдельно в сумме 50 р за 5 кг',
            ]);
            DB::table('announce_bodies')->insert([
                'id' => '3',
                'name' => 'left',
                'body' => 'Вашу <a href="/shared/order/<:order_link:>">закупку</a> покинул участник',
            ]);
            DB::table('announce_bodies')->insert([
                'id' => '4',
                'name' => 'join',
                'body' => 'К вашей <a href="/shared/order/<:order_link:>">закупке</a> присоединился новый участник.',
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
        Schema::dropIfExists('announce_bodies');
    }
}
