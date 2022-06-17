<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacketDiscountsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packet_discounts', function (Blueprint $table) {
            $table->id('id');
            $table->string('packet_code');
            $table->string('packet_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('rbp_class');
            $table->date('released_date')->nullable();
            $table->text('description');
            $table->string('status');
            $table->integer('total');
            $table->integer('discount');
            $table->integer('grand_total');
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
        Schema::drop('packet_discounts');
    }
}
