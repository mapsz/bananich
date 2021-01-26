<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('customer_id')->unsigned();
      $table->timestamp('date');
      $table->date('delivery_date');
      $table->time('delivery_time_from');
      $table->time('delivery_time_to');      
      $table->tinyInteger('confirm');
      $table->text('comment')->nullable();
      $table->text('comment_our')->nullable();
      $table->char('name',50);
      $table->char('phone',30);
      $table->string('email');
      $table->string('address');
      $table->char('appart',50)->nullable();
      $table->char('porch',50)->nullable();
      $table->decimal('subtotal', 8, 2)->default(0);
      $table->decimal('total', 8, 2)->default(0);
      $table->decimal('shipping', 8, 2)->default(0);
      $table->decimal('bonus', 8, 2)->default(0);

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
    Schema::dropIfExists('orders');
  }
}
