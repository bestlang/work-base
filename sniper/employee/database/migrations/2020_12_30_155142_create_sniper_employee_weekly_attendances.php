<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeWeeklyAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('sniper_employee_weekly_attendances', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('userId')->comment('钉钉用户ID')->nullable();
                $table->string('name')->comment('用户姓名')->nullable();
                $table->string('month')->comment('月份')->nullable();
                $table->string('week')->comment('周次')->nullable();
                $table->decimal('personal_hours', 10,2)->default(0.00)->comment('个人本周平均工时');
                $table->decimal('department_hours', 10,2)->default(0.00)->comment('部门本周平均工时');
                $table->decimal('company_hours', 10,2)->default(0.00)->comment('公司本周平均工时');
                $table->unsignedBigInteger('department')->comment('部门')->nullable();
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
        Schema::dropIfExists('sniper_employee_weekly_attendances');
    }
}
