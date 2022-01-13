<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_details', function (Blueprint $table) {
            $table->id('id');
            $table->integer('sales_order_id');
            $table->string('inventory_id');
            $table->string('inventory_name');
            $table->integer('qty');
            $table->string('uom');
            $table->double('unit_price');
            $table->double('amount');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_order_details');
    }
}
