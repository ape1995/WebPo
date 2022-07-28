<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductNameToBundlingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bundling_products', function (Blueprint $table) {
            $table->string('product_name');
        });

        Schema::table('bundling_product_frees', function (Blueprint $table) {
            $table->string('product_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bundling_products', function (Blueprint $table) {
            $table->dropColumn('product_name');
        });

        Schema::table('bundling_product_frees', function (Blueprint $table) {
            $table->dropColumn('product_name');
        });
    }
}
