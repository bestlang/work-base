<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title')->comment('公告主题');
            $table->date('notice_date')->comment('发布日期')->nullable();
            $table->text('note')->comment('备注')->nullable();
            $table->text('content')->comment('公告正文');
            $table->text('attachments')->comment('附件列表');
            $table->tinyInteger('sent')->comment('发布标志0未发布1已发布')->default(0);
            $table->nullableTimestamps();
            $table->dateTime('send_at')->comment('发送时间')->nullable();
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
        Schema::dropIfExists('sniper_employee_notices');
    }
}
