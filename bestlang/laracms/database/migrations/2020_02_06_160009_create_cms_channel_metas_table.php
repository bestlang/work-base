<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsChannelMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_channel_metas', function (Blueprint $table) {
            $table->unsignedInteger('channel_id');
            $table->string('field')->comment('字段名');
            $table->string('value', 10000)->nullable()->comment('字段值');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_channel_metas');
    }
}
