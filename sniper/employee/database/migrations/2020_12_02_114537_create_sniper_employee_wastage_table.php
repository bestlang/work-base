<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeWastageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_wastage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->string('name')->comment('姓名')->nullable();
            $table->dateTime('date')->comment('日期')->nullable();
            $table->text('apply')->comment('离职申请表')->nullable();
            $table->text('handover')->comment('交接单')->nullable();
            $table->text('record')->comment('退工手续备案表')->nullable();
            $table->text('other')->comment('其他单据')->nullable();
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
        Schema::dropIfExists('sniper_employee_wastage');
    }
}
