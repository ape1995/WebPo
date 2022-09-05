<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSomeFieldsTypeFromPacketDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packet_discounts', function (Blueprint $table) {
            $table->decimal('total')->change();
            $table->decimal('discount')->change();
            $table->decimal('grand_total')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packet_discounts', function (Blueprint $table) {
            //
        });
    }
}
