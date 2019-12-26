<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePddGoodsPromotionUrlGeneratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdd_goods_promotion_url_generates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('goods_id')->unsigned();
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
        Schema::dropIfExists('pdd_goods_promotion_url_generates');
    }
}
