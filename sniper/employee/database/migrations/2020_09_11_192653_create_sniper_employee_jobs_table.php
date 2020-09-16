<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('对应雇员信息表中的user_id');
            $table->string('start_time')->comment('开始日期');
            $table->string('end_time')->comment('开始日期');
            $table->string('company')->comment('企业名称');
            $table->string('position')->comment('岗位')->nullable();
            $table->decimal('salary', 10, 2)->comment('工资')->nullable();
            $table->text('reason')->comment('离职原因')->nullable();
            $table->string('witness_phone')->comment('证明人电话')->nullable();
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
        Schema::dropIfExists('sniper_employee_jobs');
    }
}
