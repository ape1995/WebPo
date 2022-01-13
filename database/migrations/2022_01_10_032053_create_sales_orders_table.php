<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id('id');
            $table->string('order_nbr');
            $table->string('customer_id');
            $table->date('order_date');
            $table->date('delivery_date');
            $table->integer('order_qty');
            $table->double('order_amount');
            $table->double('tax');
            $table->double('order_total');
            $table->text('description')->nullable();
            $table->string('status');
            $table->string('created_by');
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
        Schema::drop('sales_orders');
    }
}
