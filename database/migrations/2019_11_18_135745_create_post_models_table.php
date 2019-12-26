<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('模型名');
            $table->string('category_template_prefix')->comment('模型栏目页模板前缀');
            $table->string('content_template_prefix')->comment('模型内容页模板前缀');
            $table->tinyInteger('is_enabled')->comment('是否启用');
            $table->tinyInteger('is_default')->comment('是否默认模型');
            $table->integer('order_factor')->comment('排序值');
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
        Schema::dropIfExists('post_models');
    }
}
