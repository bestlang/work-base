<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('应用名称');
            $table->string('version')->default('v1.0')->comment('版本');
            $table->string('tplNs')->comment('模板前缀')->default('');
            $table->string('uri')->comment('应用URI路径')->default('')->nullable();
            $table->tinyInteger('is_default')->default(0)->comment('默认模块0否1是');
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
        Schema::dropIfExists('apps');
    }
}
