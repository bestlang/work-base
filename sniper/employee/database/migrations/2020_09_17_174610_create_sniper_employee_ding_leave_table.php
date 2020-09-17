<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeDingLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proxy')->create('sniper_employee_ding_leave', function (Blueprint $table) {
            $table->string('userid');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
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
        Schema::connection('proxy')->dropIfExists('sniper_employee_ding_leave');
    }
}
