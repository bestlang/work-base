<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('模型名');
            $table->string('template_prefix')->nullable()->comment('模板前缀');
            $table->tinyInteger('status')->default('1')->comment('状态0禁用,1启用');
            $table->softDeletes();
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
        Schema::dropIfExists('cms_models');
    }
}
