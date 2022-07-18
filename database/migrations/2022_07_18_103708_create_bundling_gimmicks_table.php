<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundlingGimmicksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundling_gimmicks', function (Blueprint $table) {
            $table->id('id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('package_type');
            $table->integer('nominal');
            $table->integer('free_qty');
            $table->text('free_descr');
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
        Schema::drop('bundling_gimmicks');
    }
}
