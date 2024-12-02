<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iorder__orderitemoptions', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('entity_type')->nullable();
      $table->integer('entity_id')->nullable();
      $table->integer('order_id')->unsigned()->nullable();
      $table->foreign('order_id')->references('id')->on('iorder__orders')->onDelete('cascade');
      $table->integer('order_item_id')->unsigned()->nullable();
      $table->foreign('order_item_id')->references('id')->on('iorder__orderitems')->onDelete('cascade');
      $table->string('options')->nullable();
      $table->float('price', 20, 2)->default(0);
      $table->string('description')->nullable();
      $table->integer('value')->nullable();
      $table->string('extra_data')->nullable();

      // Audit fields
      $table->timestamps();
      $table->auditStamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iorder__orderitemoptions', function (Blueprint $table) {
      $table->dropForeign(['order_id']);
      $table->dropForeign(['order_item_id']);
    });
    Schema::dropIfExists('iorder__orderitemoptions');
  }
};
