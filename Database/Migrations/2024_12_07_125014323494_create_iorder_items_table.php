<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Iorder\Entities\Status;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iorder__items', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields...
      $table->integer('order_id')->unsigned()->nullable();
      $table->foreign('order_id')->references('id')->on('iorder__orders')->onDelete('cascade');
      $table->integer('status_id')->default(Status::ITEM_PENDING);
      $table->string('entity_type')->nullable();
      $table->integer('entity_id')->nullable();
      $table->string('title')->nullable();
      $table->integer('quantity')->nullable();
      $table->float('price', 20, 2)->default(0);
      $table->float('total', 50, 2)->default(0);
      $table->string('options')->nullable();
      $table->integer('discount')->nullable();
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
    Schema::dropIfExists('iorder__items');
  }
};
