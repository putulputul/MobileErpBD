<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('product_id');
            $table->string('product_name');
            $table->decimal('stock_quantity');
            $table->decimal('sale_quantity');
            $table->decimal('remain_quantity');
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
        Schema::dropIfExists('stocks');
    }
}
