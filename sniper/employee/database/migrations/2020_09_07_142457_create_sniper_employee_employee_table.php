<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_employee', function (Blueprint $table) {
            //$table->string('')->comment('')->nullable();
            //email , password进主表
            $table->unsignedBigInteger('user_id')->index()->comment('对应user表数据ID');
            $table->string('real_name')->comment('真实姓名')->nullable();
            $table->unsignedBigInteger('department_id')->nullable()->comment('部门ID');
            $table->string('tag')->nullable()->comment('标签');
            $table->unsignedBigInteger('position_id')->nullable()->comment('职位ID');
            $table->string('phone')->nullable()->comment('手机');

            $table->string('work_place')->comment('工作地点')->nullable();

            $table->tinyInteger('gender')->comment('性别:0未知1男2女')->default(0);
            $table->string('native_land')->comment('籍贯')->nullable();
            $table->string('birthday')->comment('生日')->nullable();
            $table->string('id_card')->nullable()->comment('身份证号');

            $table->string('school')->comment('学校')->nullable();
            $table->string('study_duration')->comment('学习时间')->nullable();
            $table->string('degree')->comment('学位')->nullable();


            $table->string('marital')->comment('婚姻状况')->nullable();
            $table->string('mate')->comment('配偶姓名')->nullable();
            $table->smallInteger('children')->comment('子女数量')->default(0);
            $table->string('emergency')->nullable()->comment('紧急联系人');
            $table->string('emergency_phone')->comment('紧急联系人电话')->nullable();
            $table->string('avatar')->comment('头像')->nullable();

            $table->text('leaving')->comment('离职证明');
            $table->text('physical')->comment('体检证明');
            $table->text('certificate')->comment('学历证明');
            $table->text('interview')->comment('面试记录');
            $table->text('contract')->comment('劳动合同');
            $table->text('employment')->comment('录用通知书');
            $table->text('other')->comment('其他');
            $table->tinyInteger('onJob')->default(1)->comment('是否在职1在职0离职');
            $table->string('userid')->default('')->comment('钉钉用户id');
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
            Schema::dropIfExists('sniper_employee_employee');
    }
}
