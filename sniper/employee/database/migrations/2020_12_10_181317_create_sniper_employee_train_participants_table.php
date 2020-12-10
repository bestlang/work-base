<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeTrainParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_train_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('train_id')->comment('培训ID')->nullable();
            $table->unsignedBigInteger('user_id')->comment('用户ID')->nullable();
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
        Schema::dropIfExists('sniper_employee_train_participants');
    }
}
