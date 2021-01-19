<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperPositionEmployeeAbilityScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //员工 - 能力得分记录
        Schema::create('sniper_position_employee_ability_score', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->comment('员工ID');
            $table->unsignedBigInteger('ability_category_id')->comment('能力分类ID');
            $table->unsignedBigInteger('ability_id')->comment('能力ID');
            $table->smallInteger('totalScore')->comment('能力分值');
            $table->smallInteger('okScore')->comment('达标分值');
            $table->smallInteger('score')->comment('得分值');
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
        Schema::dropIfExists('sniper_position_employee_ability_score');
    }
}
