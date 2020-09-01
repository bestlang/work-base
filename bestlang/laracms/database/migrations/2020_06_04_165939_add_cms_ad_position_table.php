<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCmsAdPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //广告位版位
        Schema::create('cms_ad_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('版位名称');
            $table->tinyInteger('enabled')->default(1)->comment('是否启用1是0否');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('order_factor')->default('0')->comment('排序值');
            $table->softDeletes();
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
        Schema::dropIfExists('cms_ad_positions');
    }
}
