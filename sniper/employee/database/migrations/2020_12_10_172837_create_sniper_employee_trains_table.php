<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_trains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('课程名称')->nullable();
            $table->text('content')->comment('课程内容')->nullable();
            $table->string('start_time')->comment('开始日期')->nullable();
            $table->string('end_time')->comment('结束日期')->nullable();
            $table->smallInteger('last_days')->comment('持续时间天')->nullable();
            $table->smallInteger('last_hours')->comment('持续时间小时')->nullable();
            $table->smallInteger('last_minutes')->comment('持续时间分钟')->nullable();
            $table->string('teacher')->comment('讲师')->nullable();
            $table->string('location')->comment('培训地点')->nullable();
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
        Schema::dropIfExists('sniper_employee_trains');
    }
}
