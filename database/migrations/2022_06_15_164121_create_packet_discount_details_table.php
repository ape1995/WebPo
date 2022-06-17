<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacketDiscountDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packet_discount_details', function (Blueprint $table) {
            $table->id('id');
            $table->integer('packet_discount_id');
            $table->string('inventory_code');
            $table->string('inventory_name');
            $table->integer('qty');
            $table->integer('unit_price');
            $table->integer('total_amount')->nullable();
            $table->decimal('discount_percentage')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->decimal('amount')->nullable();
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
        Schema::drop('packet_discount_details');
    }
}
