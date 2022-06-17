<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPacketDiscountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packet_discount_details', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            $table->integer('packet_discount_id')->nullable()->change();
            $table->decimal('unit_price')->nullable()->change();
            $table->decimal('total_amount')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packet_discount_details', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
