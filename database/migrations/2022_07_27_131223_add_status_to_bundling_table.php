<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBundlingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bundling_products', function (Blueprint $table) {
            $table->string('status')->default('Draft');
        });

        Schema::table('bundling_gimmicks', function (Blueprint $table) {
            $table->string('status')->default('Draft');
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
            $table->dropColumn('status');
        });

        Schema::table('bundling_gimmicks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
