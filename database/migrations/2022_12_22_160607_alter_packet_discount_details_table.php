<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPacketDiscountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packet_discounts', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('discount');
            $table->dropColumn('grand_total');
        });

        Schema::table('packet_discount_details', function (Blueprint $table) {
            $table->dropColumn('total_amount');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('discount_amount');
            $table->dropColumn('amount');
        });

        Schema::table('packet_discounts', function (Blueprint $table) {
            $table->double('total')->nullable();
            $table->double('discount')->nullable();
            $table->double('grand_total')->nullable();
        });

        Schema::table('packet_discount_details', function (Blueprint $table) {
            $table->double('total_amount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
