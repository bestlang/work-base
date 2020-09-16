<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeDingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proxy')->create('sniper_employee_ding_users', function (Blueprint $table) {
            $table->string('errcode')->nullable()->default(0);
            $table->string('unionid')->nullable();
            $table->string('remark')->nullable();
            $table->string('userid')->nullable();
            $table->text('isLeaderInDepts')->nullable();
            $table->string('isBoss')->nullable();
            $table->string('hiredDate')->nullable();
            $table->string('isSenior')->nullable();
            $table->string('tel')->nullable();
            $table->string('department')->nullable(); // array cast to string
            $table->string('workPlace')->nullable();
            $table->string('email')->nullable();
            $table->string('orderInDepts')->nullable();
            $table->string('mobile')->nullable();
            $table->string('errmsg')->nullable();
            $table->string('active')->nullable();
            $table->string('avatar')->nullable();
            $table->string('isAdmin')->nullable();
            $table->string('isHide')->nullable();
            $table->string('jobnumber')->nullable();
            $table->string('name')->nullable();
            $table->string('extattr')->nullable();//object cast to string
            $table->string('stateCode')->nullable();
            $table->string('position')->nullable();
            $table->string('roles')->nullable();// array cast to string
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
        Schema::connection('proxy')->dropIfExists('sniper_employee_ding_users');
    }
}
