<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('推荐位名称');
            $table->tinyInteger('is_channel')->default(0)->comment('0文章1栏目');
            $table->integer('parent_id')->default(0)->comment('所属栏目推荐位');
            $table->integer('order_factor')->default(100)->comment('排序字段');
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
        Schema::dropIfExists('cms_positions');
    }
}
