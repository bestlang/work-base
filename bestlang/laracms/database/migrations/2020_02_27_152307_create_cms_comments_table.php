<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('content_id')->default(0)->comment('内容ID');
            $table->unsignedBigInteger('user_id')->default(0)->comment('评论人ID');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父评论ID');
            $table->string('ip', 50)->default('')->nullable()->comment('ip地址');
            $table->text('content');
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_comments');
    }
}
