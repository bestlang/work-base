<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostModelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_model_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('model_id')->comment('所属模型ID');
            $table->string('field')->comment('字段');
            $table->string('label')->comment('名称');
            $table->string('default_value')->comment('默认值');
            $table->string('options')->comment('可选项');
            $table->string('model_item_type_id')->comment('类型ID');
            $table->string('order_factor')->comment('排序值');
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
        Schema::dropIfExists('post_model_items');
    }
}
