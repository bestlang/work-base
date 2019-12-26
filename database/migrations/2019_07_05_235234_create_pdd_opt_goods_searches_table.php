<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePddOptGoodsSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdd_opt_goods_searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('opt_id');
            $table->integer('page');
            $table->integer('page_size');
            $table->jsonb('aio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdd_opt_goods_searches');
    }
}
