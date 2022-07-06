<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SalesOrder;

class AddOrderNbrMergeToSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->string('order_nbr_merge')->nullable();
            $table->integer('order_merged_by')->nullable();
        });

        $modelCollection = SalesOrder::all();
		foreach($modelCollection as $model) {
			//Do your calculation whit old columns and save it in the new column.
			$model->order_nbr_merge = $model->order_nbr;
			$model->order_merged_by = 2;
			$model->save();
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn('order_nbr_merge');
            $table->dropColumn('order_merged_by');
        });
    }
}
