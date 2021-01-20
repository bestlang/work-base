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
            $table->unsignedBigInteger('user_id')->comment('员工ID');
            $table->unsignedBigInteger('position_id')->comment('职位ID');
            $table->unsignedBigInteger('ability_category_id')->comment('能力分类ID');
            $table->unsignedBigInteger('ability_id')->comment('能力ID');
            $table->string('name')->comment('能力名')->nullable();
            $table->text('detail')->comment('能力详情');
            $table->smallInteger('totalScore')->comment('能力分值');
            $table->smallInteger('okScore')->comment('达标分值');
            $table->smallInteger('score')->comment('得分值')->default(0);
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
