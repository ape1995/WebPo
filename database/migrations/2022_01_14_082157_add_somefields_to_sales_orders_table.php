<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomefieldsToSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->integer('canceled_by')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->integer('submitted_by')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->integer('processed_by')->nullable();
            $table->dateTime('processed_at')->nullable();
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
            $table->dropColumn('canceled_by');
            $table->dropColumn('submitted_by');
            $table->dropColumn('rejected_by');
            $table->dropColumn('processed_by');
            $table->dropColumn('rejected_reason');
        });
    }
}
