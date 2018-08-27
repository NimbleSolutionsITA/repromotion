<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_base_number');
            $table->string('printing_position');
            $table->string('printing_technique');
            $table->string('printing_technique_description');
            $table->string('pricing_type');
            $table->string('manipulation');
            $table->string('color_code');
            $table->string('print_model');
            $table->integer('area');
            $table->integer('number_of_colours');
            $table->integer('min_qty');
            $table->decimal('price', 8, 2);
            $table->decimal('setup', 8, 2);
            $table->decimal('handling', 8, 2);
            $table->decimal('apply', 8, 2);
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
        Schema::dropIfExists('printinfos');
    }
}
