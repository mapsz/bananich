<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_order_statuses', function (Blueprint $table) {
            $table->integer('id');
            $table->char('name', 100);
        });

        
        {//Seed
            DB::table('shared_order_statuses')->insert([
                'id' => '1',
                'name' => 'Успешен',
            ]);
            DB::table('shared_order_statuses')->insert([
                'id' => '0',
                'name' => 'Отменён',
            ]);
            DB::table('shared_order_statuses')->insert([
                'id' => '-1',
                'name' => 'Истёк',
            ]);
            DB::table('shared_order_statuses')->insert([
                'id' => '100',
                'name' => 'Оформление',
            ]);
            DB::table('shared_order_statuses')->insert([
                'id' => '200',
                'name' => 'Открыт',
            ]);
            DB::table('shared_order_statuses')->insert([
                'id' => '300',
                'name' => 'Зафиксирован',
            ]);
            DB::table('shared_order_statuses')->insert([
                'id' => '500',
                'name' => 'Оформлен',
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
        Schema::dropIfExists('shared_order_statuses');
    }
}
