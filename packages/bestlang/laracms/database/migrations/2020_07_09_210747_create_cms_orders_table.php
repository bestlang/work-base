<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('购买商品名称')->nullable();
            $table->string('order_no')->comment('订单号');
            $table->string('product_id')->comment('商品ID')->nullable();
            $table->decimal('money', 10, 2)->comment('订单金额');
            $table->tinyInteger('status')->comment('订单状态0未支付1已支付')->default(0);
            $table->tinyInteger('gateway')->comment('支付方式1微信2支付宝3其它')->default(1);
            $table->nullableTimestamps();
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
        Schema::dropIfExists('cms_orders');
    }
}
