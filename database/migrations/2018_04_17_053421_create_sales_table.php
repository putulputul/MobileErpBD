<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->date('sale_date');
            $table->integer('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('product_name');
            $table->decimal('unit_price')->nullable();
            $table->decimal('quantity1');
            $table->string('unit_of_measurement1');
            $table->decimal('quantity2')->nullable();
            $table->string('unit_of_measurement2')->nullable();
            $table->decimal('total_amount');
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
        Schema::dropIfExists('sales');
    }
}
