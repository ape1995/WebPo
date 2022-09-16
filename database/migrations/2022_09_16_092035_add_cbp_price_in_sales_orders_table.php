<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCbpPriceInSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->double('cbp_total')->nullable();
            $table->double('cbp_tax')->nullable();
            $table->double('cbp_grand_total')->nullable();
        });

        Schema::table('sales_order_details', function (Blueprint $table) {
            $table->double('cbp_price')->nullable();
            $table->double('cbp_total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn('cbp_total');
            $table->dropColumn('cbp_tax');
            $table->dropColumn('cbp_grand_total');
        });

        Schema::table('sales_order_details', function (Blueprint $table) {
            $table->dropColumn('cbp_price');
            $table->dropColumn('cbp_total');
        });
    }
}
