<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeDingAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proxy')->create('sniper_employee_ding_attendance', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('baseCheckTime')->nullable();
            $table->string('checkType')->nullable();
            $table->string('corpId')->nullable();
            $table->string('groupId')->nullable();
            $table->string('locationResult')->nullable();
            $table->string('planId')->nullable();
            $table->string('recordId')->nullable();
            $table->string('timeResult')->nullable();
            $table->string('userCheckTime')->nullable();
            $table->string('userId')->nullable();
            $table->string('workDate')->nullable();
            $table->string('procInstId')->nullable();
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
        Schema::connection('proxy')->dropIfExists('sniper_employee_ding_attendance');
    }
}
