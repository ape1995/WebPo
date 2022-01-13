<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id('id');
            $table->string('inventory_id');
            $table->string('inventory_name');
            $table->integer('qty');
            $table->string('uom');
            $table->double('unit_price');
            $table->double('amount');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('customer_id');
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
        Schema::drop('carts');
    }
}
