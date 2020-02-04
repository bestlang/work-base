<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsModelFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_model_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('model_id')->comment('模型ID');
            $table->string('type')->comment('字段类型,text,select,txt, image ....自定义类型...');
            $table->string('field')->comment('模型字段名');
            $table->string('label')->comment('模型标签名');
            $table->string('extra', 2000)->nullable()->comment('选项');
            $table->tinyInteger('is_channel')->default(0)->comment('是否属于栏目:1属于栏目模型0属于内容模型');
            $table->tinyInteger('is_custom')->default(0)->comment('是否自定义:0否1是');
            $table->tinyInteger('is_display')->default(1)->comment('是否显示在表单:1显示0不显示');
            $table->tinyInteger('is_required')->default(0)->comment('是否表单必填项:1是0否');
            $table->integer('order_factor')->default(0)->comment('越大越靠前');
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
        Schema::dropIfExists('cms_model_fields');
    }
}
