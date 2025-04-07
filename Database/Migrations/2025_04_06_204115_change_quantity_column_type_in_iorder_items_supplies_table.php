<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
      Schema::table('iorder__items', function (Blueprint $table) {
        $table->float('quantity', 20, 2)->nullable()->change();
      });

      Schema::table('iorder__supplies', function (Blueprint $table) {
        $table->float('quantity', 20, 2)->nullable()->change();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
};
