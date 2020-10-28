<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名称');
            $table->integer('model_id')->nullable()->comment('模型ID');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键字');
            $table->string('description')->nullable()->comment('描述');
            $table->string('template')->nullable()->comment('栏目页模板');
            $table->string('content_template')->nullable()->comment('内容页模板');
            $table->string('mobile_template')->nullable()->comment('手机栏目页模板');
            $table->string('mobile_content_template')->nullable()->comment('手机内容页模板');
            $table->tinyInteger('is_blank')->default(0)->comment('是否新窗口打开:0否1是');
            $table->integer('order_factor')->unsigned()->default(0)->comment('排序字段');
            // We declare here the nested set structure columns/fields
            $table->nestedSet();
            // The previous `nestedSet` blueprint helper is equivalent to
            // the following column/field declarations:
            //
            // $table->integer('parent_id')->unsigned()->nullable()->index();
            // $table->foreign('parent_id')->references('id')->on($table->getTable());
            // $table->integer('left')->unsigned()->nullable()->index();
            // $table->integer('right')->unsgined()->nullable()->index();
            // $table->integer('depth')->unsigned()->nullable()->index();
            //
            // Feel free to modify at your own will but note that all columns
            // *must be present* and initialized on the model accordingly.

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
        Schema::dropIfExists('cms_channels');
    }
}
