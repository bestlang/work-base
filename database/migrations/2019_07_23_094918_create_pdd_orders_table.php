<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePddOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdd_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('goods_name')->nullable();
            $table->string('goods_price')->nullable();
            $table->string('goods_quantity')->nullable();
            $table->string('goods_id')->nullable();
            $table->string('promotion_rate')->nullable();
            $table->string('goods_thumbnail_url')->nullable();
            $table->string('custom_parameters')->nullable();
            $table->string('promotion_amount')->nullable();
            $table->string('order_status')->nullable();
            $table->string('order_pay_time')->nullable();
            $table->string('order_create_time')->nullable();
            $table->string('order_group_success_time')->nullable();
            $table->string('order_amount')->nullable();
            $table->string('order_status_desc')->nullable();
            $table->string('order_modify_at')->nullable();
            $table->string('order_sn')->nullable();
            $table->string('p_id')->nullable();
            $table->string('last_order_id')->nullable();
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
        Schema::dropIfExists('pdd_orders');
    }
}
