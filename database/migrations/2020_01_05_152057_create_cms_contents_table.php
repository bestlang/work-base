<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('channel_id')->comment('栏目ID');
            $table->integer('model_id')->comment('模型ID');
            $table->integer('user_id')->comment('用户ID');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键字');
            $table->string('description')->nullable()->comment('描述');
            $table->tinyInteger('status')->default(1)->comment('状态:0草稿1审核通过');
            $table->integer('top_factor')->default(0)->comment('置顶值');
            $table->string('author')->nullable()->comment('作者');
            $table->string('origin')->nullable()->comment('来源');
            $table->string('origin_url')->nullable()->comment('来源链接');
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
        Schema::dropIfExists('cms_contents');
    }
}
