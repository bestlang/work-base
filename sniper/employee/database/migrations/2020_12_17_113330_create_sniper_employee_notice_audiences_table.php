<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeNoticeAudiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_notice_audiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('notice_id')->comment('通知ID')->nullable();
            $table->unsignedBigInteger('user_id')->comment('用户ID')->nullable();
            $table->tinyInteger('sent')->comment('已发送标志0未送1已发送')->default(0);
            $table->timestamp('send_at')->comment('发送时间')->nullable();
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
        Schema::dropIfExists('sniper_employee_notice_audiences');
    }
}
