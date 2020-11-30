<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeePositionChangeSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_position_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date')->comment('日期')->nullable();
            $table->unsignedBigInteger('user_id')->comment('用户')->nullable();
            $table->string('name')->comment('姓名')->nullable();
            $table->string('positionBefore')->comment('变更前职位')->nullable();
            $table->string('positionAfter')->comment('变更后职位')->nullable();
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
        Schema::dropIfExists('sniper_employee_position_changes');
    }
}
