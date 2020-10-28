<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsFieldTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_field_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('类型字符串标识');
            $table->string('name')->comment('类型名字');
            $table->string('extra', 5000)->nullable()->comment('附加信息');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_field_types');
    }
}
