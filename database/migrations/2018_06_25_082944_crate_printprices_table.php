<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CratePrintpricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printprices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_base');
            $table->string('color_code');
            $table->string('position');
            $table->string('print_model');
            $table->integer('min_qty');
            $table->decimal('price', 8, 2);
            $table->decimal('setup', 8, 2);
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
        Schema::dropIfExists('printprices');
    }
}
