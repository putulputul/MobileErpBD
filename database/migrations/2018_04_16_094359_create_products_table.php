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
            $table->integer('item_id');
            $table->string('item_name');
            $table->string('name');
            $table->decimal('purchase_price')->nullable();
            $table->decimal('sale_price')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('mrp');
            $table->string('code')->nullable();
            $table->string('brand')->nullable();
            $table->string('model_number')->nullable();
            $table->string('product_type')->nullable();
            $table->string('description')->nullable();
            $table->decimal('stock_quantity');
            $table->integer('unit_of_measurement_id');
            $table->string('unit_of_measurement_name');
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
