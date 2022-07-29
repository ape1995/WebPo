<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsToBundlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bundling_products', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->date('released_at')->nullable();
            $table->integer('released_by')->default(1);
            $table->integer('updated_by')->default(1);
        });

        Schema::table('bundling_gimmicks', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->date('released_at')->nullable();
            $table->integer('released_by')->default(1);
            $table->integer('updated_by')->default(1);
        });

        Schema::table('packet_discounts', function (Blueprint $table) {
            $table->integer('created_by')->default(1);
            $table->integer('released_by')->default(1);
            $table->integer('updated_by')->default(1);
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
            $table->dropColumn('created_by');
            $table->dropColumn('released_at');
            $table->dropColumn('released_by');
            $table->dropColumn('updated_by');
        });

        Schema::table('bundling_gimmicks', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('released_at');
            $table->dropColumn('released_by');
            $table->dropColumn('updated_by');
        });

        Schema::table('packet_discounts', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('released_by');
            $table->dropColumn('updated_by');
        });
    }
}
