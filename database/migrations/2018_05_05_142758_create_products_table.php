<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_number');
            $table->string('product_base');
            $table->string('name');
            $table->string('slug');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('catalog');
            $table->string('position');
            $table->string('print_model');
            $table->integer('stock');
            $table->integer('min');
            $table->string('category1');
            $table->string('category2');
            $table->string('category3');
            $table->text('long_description');
            $table->text('short_description');
            $table->string('material_type');
            $table->string('dimensions');
            $table->string('gender');
            $table->decimal('start_price', 8, 2);
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
        Schema::dropIfExists('products');
    }
}