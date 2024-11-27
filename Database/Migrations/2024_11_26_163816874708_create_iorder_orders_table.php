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
    Schema::create('iorder__orders', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');

      $table->float('total', 50, 2)->default(0);
      $table->integer('status_id')->nullable();
      $table->integer('customer_id')->nullable();
      $table->string('customer_first_name')->nullable();
      $table->string('customer_last_name')->nullable();
      $table->string('customer_email')->nullable();
      $table->string('customer_phone')->nullable();
      $table->string('payment_name')->nullable();
      $table->string('payment_country')->nullable();
      $table->string('payment_city')->nullable();
      $table->string('payment_province')->nullable();
      $table->string('payment_zip_code')->nullable();
      $table->string('payment_extra_data')->nullable();
      $table->string('shipping_name')->nullable();
      $table->string('shipping_customer_first_name')->nullable();
      $table->string('shipping_customer_last_name')->nullable();
      $table->string('shipping_customer_phone')->nullable();
      $table->string('shipping_country')->nullable();
      $table->string('shipping_city')->nullable();
      $table->string('shipping_province')->nullable();
      $table->string('shipping_address_1')->nullable();
      $table->string('shipping_address_2')->nullable();
      $table->string('shipping_amount')->nullable();
      $table->string('shipping_extra_data')->nullable();
      $table->string('currency')->nullable();
      $table->string('options')->nullable();
      $table->string('type')->nullable();

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
    Schema::dropIfExists('iorder__orders');
  }
};
