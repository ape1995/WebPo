<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderPromosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_promos', function (Blueprint $table) {
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
            $table->integer('created_by');
            $table->integer('updapted_by')->nullable();
            $table->integer('canceled_by')->nullable();
            $table->date('canceled_at')->nullable();
            $table->integer('submitted_by')->nullable();
            $table->date('submitted_at')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->date('rejected_at')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->integer('processed_by')->nullable();
            $table->date('processed_at')->nullable();
            $table->string('order_type');
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
        Schema::drop('sales_order_promos');
    }
}
