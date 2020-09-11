<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_education', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('对应雇员信息表中的user_id');
            $table->string('start_time')->comment('开始日期');
            $table->string('end_time')->comment('开始日期');
            $table->string('school')->comment('学校');
            $table->string('specialize')->comment('专业')->nullable();
            $table->string('degree')->comment('学位');
            $table->tinyInteger('unified')->comment('是否统招1:是0:否')->default(1);
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
        Schema::dropIfExists('sniper_employee_education');
    }
}
