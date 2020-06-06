<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCmsAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('position_id')->comment('广告位ID');
            $table->string('name')->comment('广告名称');
            $table->tinyInteger('enabled')->default('1')->comment('是否启用1是0否');
            $table->timestamp('start_time')->nullable()->comment('展现开始时间');
            $table->timestamp('end_time')->nullable()->comment('展现结束时间');
            $table->tinyInteger('type')->default(1)->comment('类型1图片2文字3代码');
            $table->string('url')->nullable()->comment('链接地址');
            $table->string('text')->nullable()->comment('广告文字内容');
            $table->string('code', 1000)->nullable()->comment('广告代码内容');
            $table->string('image')->nullable()->comment('广告图片');
            $table->string('tiny_image')->nullable()->comment('小屏幕广告图');
            $table->string('target')->default('_black')->comment('跳转页面方式:_black,_self');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_ads');
    }
}
