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
    Schema::create('iorder__supplies', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields...
      $table->integer('item_id')->unsigned();
      $table->foreign('item_id')->references('id')->on('iorder__items')->onDelete('cascade');
      $table->integer('status_id')->default(Status::SUPPLY_PENDING);
      $table->integer('quantity')->default(1);
      $table->float('price', 20, 2)->default(0);
      $table->float('total', 50, 2)->default(0);
      $table->integer('supplier_id')->unsigned();
      $table->foreign('supplier_id')->references('id')->on('users');
      $table->text('comment')->nullable();
      $table->text('options')->nullable();
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
    Schema::dropIfExists('iorder__supplies');
  }
};
